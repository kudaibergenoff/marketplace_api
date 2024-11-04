<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAttribute; // Импортируйте модель атрибутов продукта
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем первый продукт
        $product1 = Product::create(
            [
                "name" => "Продукт 1",
                "description" => "Продукт 1",
                "price" => 10000,
                "category_id" => 1,
                "seller_id" => 3,
            ]
        );

        // Добавляем атрибуты к продукту 1
        foreach ([
                     [
                         "attribute_name" => "Размер",
                         "attribute_value" => "M"
                     ],
                     [
                         "attribute_name" => "Цвет",
                         "attribute_value" => "Красный"
                     ]
                 ] as $attribute) {
            $product1->attributes()->create($attribute);
        }

        // Создаем второй продукт
        $product2 = Product::create(
            [
                "name" => "Продукт 2",
                "description" => "Продукт 2",
                "price" => 10000,
                "category_id" => 2,
                "seller_id" => 3,
            ]
        );

        // Добавляем атрибуты к продукту 2
        foreach ([
                     [
                         "attribute_name" => "Размер",
                         "attribute_value" => "XL"
                     ],
                     [
                         "attribute_name" => "Цвет",
                         "attribute_value" => "Черный"
                     ]
                 ] as $attribute) {
            $product2->attributes()->create($attribute);
        }
    }
}
