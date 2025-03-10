<?php

namespace App\Services\Interfaces;

interface ProductServiceInterface{
    public function getAllProducts();

    public function createProduct(array $data);

    public function getProductByArticle(string $article);

    public function deleteProduct(string $article);

    public function updateProduct(string $article, array $data);
}