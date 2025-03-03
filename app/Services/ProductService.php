<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Models\Product;

class ProductService{
    protected $productRepo;

    public function __construct(ProductRepository $productRepo){
        $this->productRepo = $productRepo;
    }

    public function getAllProducts()
    {
        return $this->productRepo->getAll()->map(function ($product) {
            $product->attributes = $product->getDecodedAttributes();
            return $product;
        });
    }

    public function createProduct(array $data): Product
    {
        return $this->productRepo->create($data);
    }

    public function getProductByArticle(string $article): ?Product
    {
        $product = $this->productRepo->findByArticle($article);
        if ($product) {
            $product->attributes = $product->getDecodedAttributes();
        }
        return $product;
    }

    public function deleteProduct(string $article): bool
    {
        return $this->productRepo->deleteByArticle($article);
    }

    public function updateProduct(string $article, array $data): ?Product
    {
        return $this->productRepo->updateByArticle($article, $data);
    }

}