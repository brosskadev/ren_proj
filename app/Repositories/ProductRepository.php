<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAll(){
        return Product::all();
    }

    public function create(array $data): Product{
        return Product::create($data);
    }

    public function findByArticle(string $article): ?Product{
        return Product::where("article", $article)->first();
    }

    public function deleteByArticle(string $article): Bool{
        $product = $this->findByArticle($article);

        if (!$product) {
            return false;
        }

        return $product->delete();
    }

    public function updateByArticle(string $article, array $data): ?Product{
        $product = $this->findByArticle($article);

        if (!$product) {
            return null;
        }

        $product->update($data);

        return $product;
    }

}