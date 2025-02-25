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
        $validatedData = $request->validate([
            'article' => 'required|unique:products',
            'name' => 'required',
            'status' => 'required',
            'attributes' => 'nullable|array',
        ]);
    
        try {
            $product = Product::create($validatedData);
    
            return response()->json([
                'success' => true,
                'message' => 'Продукт добавлен',
                'product' => $product
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при добавлении продукта',
                'error' => $e->getMessage()
            ], 500);
        }
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

    public function update(Request $request, $article) {
        $request->validate([
            'article' => 'required',
            'name' => 'required',
            'status' => 'required',
            'attributes' => 'nullable|array',
        ]);
    
        $product = Product::where('article', $article)->first();
    
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Продукт не найден'], 404);
        }
    
        $product->update($request->all());
    
        return response()->json(['success' => true, 'message' => 'Продукт обновлен']);
    }

}
