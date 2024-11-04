<?php

namespace App\Services;

use App\Models\ProductAttribute;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductService
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {}

    public function getProducts()
    {
        $products = $this->productRepository->all();
        if (auth()->user()->hasRole('seller')) {
            $products = $products->where('seller_id', auth()->id());
        }
        return $products;
    }

    public function createProduct($data)
    {
        return $this->productRepository->create($data);
    }

    public function updateProduct($data, $id)
    {
        return $this->productRepository->update($id, $data);
    }
    public function deleteProduct($id)
    {
        return $this->productRepository->delete($id);
    }

    public function addAttributeToProduct($productId, $attributeData)
    {
        return $this->productRepository->addAttributeToProduct($productId, $attributeData);
    }

    public function deleteAttributesByProductId($productId)
    {
        return $this->productRepository->deleteAttributesByProductId($productId);
    }

    public function upsertAttributeForProduct($productId, $attributeData)
    {
        return ProductAttribute::updateOrCreate(
            ['product_id' => $productId, 'attribute_name' => $attributeData['attribute_name']],
            ['attribute_value' => $attributeData['attribute_value']]
        );
    }


}
