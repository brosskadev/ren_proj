<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    protected ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function main(){
        $products = $this->productService->getAllProducts();
        return view('mainpage', ['user' => Auth::user(), 'products' => $products]);
    }

    public function store(StoreProductRequest $request){
        try {
            $product = $this->productService->createProduct($request->validated());

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
        $product = $this->productService->getProductByArticle($article);

        if (!$product) {
            return response()->json(['error' => 'Продукт не найден'], 404);
        }

        return response()->json($product);
    }

    public function deleteProduct($article){
        if (!$this->productService->deleteProduct($article)) {
            return response()->json(['error' => 'Продукт не найден'], 404);
        }

        return response()->json(['message' => 'Продукт успешно удален'], 200);
    }

    public function update(UpdateProductRequest $request, $article){
        $updatedProduct = $this->productService->updateProduct($article, $request->validated());

        if (!$updatedProduct) {
            return response()->json(['success' => false, 'message' => 'Продукт не найден'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Продукт обновлен']);
    }

}
