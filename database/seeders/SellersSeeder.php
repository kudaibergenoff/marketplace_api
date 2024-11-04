<?php

namespace Database\Seeders;

use App\Models\Seller;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SellersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Seller::create([
            'user_id' => 3,
            'contact_person' => 'Иван Иванов',
            'company_name' => 'Ивановская компания',
            'website' => 'http://ivanovskaya-kompaniya.com',
        ]);

        Seller::create([
            'user_id' => 4,
            'contact_person' => 'Петр Петров',
            'company_name' => 'Петровская компания',
            'website' => 'http://petrovskaya-kompaniya.com',
        ]);
    }
}
