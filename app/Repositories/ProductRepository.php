<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $product)
    {
        parent::__construct($product);
    }

    public function addAttributeToProduct($productId, array $attributeData)
    {
        return ProductAttribute::create(array_merge($attributeData, ['product_id' => $productId]));
    }

    public function deleteAttributesByProductId($productId)
    {
        return ProductAttribute::where('product_id', $productId)->delete();
    }
}
