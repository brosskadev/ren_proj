<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index(){
        $products = Product::all();

        foreach ($products as $product) {
            if (is_string($product->attributes)) {
                $decoded = json_decode($product->attributes, true);
                $product->attributes = is_array($decoded) ? $decoded : [];
            }
        }

        return view('mainpage', compact('products'));
    }

    public function store(Request $request){
        $request -> validate([
            'article' => 'required|unique:products',
            'name' => 'required',
            'status' => 'required',
            'attributes' => 'nullable|array',
        ]);
        Product::create($request->all());

        return redirect()->back()->with('success','Продукт добавлен');
    }

    public function getProductByArticle($article){
        $product = Product::where('article', $article)->first();

        if (!$product) {
            return response()->json(['error' => 'Продукт не найден'], 404);
        }

        // Декодируем JSON-атрибуты, если это строка
        if (is_string($product->attributes)) {
            $product->attributes = json_decode($product->attributes, true) ?? [];
        }

        // Если атрибутов нет, возвращаем сообщение
        if (empty($product->attributes)) {
            $product->attributes = [['key' => '—', 'value' => 'Нет атрибутов']];
        }

        return response()->json($product);
    }

    public function deleteProduct($article){
        $product = Product::where('article', $article)->first();

        if (!$product) {
            return response()->json(['error' => 'Продукт не найден'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Продукт успешно удален'], 200);
    }

}
