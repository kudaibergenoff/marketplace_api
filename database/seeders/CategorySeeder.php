<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(
            [
                'parent_id' => 0,
                'name' => 'Категория 1',
                'slug' => 'category-1',
                'description' => 'Категория 1',
                'status' => true
            ]
        );
        Category::create(
            [
                'parent_id' => 0,
                'name' => 'Категория 2',
                'slug' => 'category-2',
                'description' => 'Категория 2',
                'status' => true
            ]
        );
        Category::create(
            [
                'parent_id' => 1,
                'name' => 'Категория 3',
                'slug' => 'category-3',
                'description' => 'Категория 3',
                'status' => true
            ]
        );
        Category::create(
            [
                'parent_id' => 1,
                'name' => 'Категория 4',
                'slug' => 'category-4',
                'description' => 'Категория 4',
                'status' => true
            ]
        );
        Category::create(
            [
                'parent_id' => 2,
                'name' => 'Категория 5',
                'slug' => 'category-5',
                'description' => 'Категория 5',
                'status' => true
            ]
        );
    }
}
