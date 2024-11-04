<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    public function __construct(private ProductRepository $productRepository)
    {
        //
    }

    public function getProducts()
    {
        $this->productRepository->all();
    }
}
