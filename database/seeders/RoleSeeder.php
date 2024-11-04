<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'admin',
            'display_name' => 'Главный администратор'
        ]);
        Role::create([
            'name' => 'manager',
            'display_name' => 'Контент-менеджер'
        ]);
        Role::create([
            'name' => 'seller',
            'display_name' => 'Продавец'
        ]);
    }
}
