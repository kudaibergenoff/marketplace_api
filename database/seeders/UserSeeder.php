<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRoleId = 1;

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@marketplace.com',
            'phone' => '77009876543',
            'password' => bcrypt('Aa123123'),
        ]);

        $admin->roles()->attach($adminRoleId);

        $managerRoleId = 2;

        $manager = User::create([
            'name' => 'ContentManager',
            'email' => 'manager@marketplace.com',
            'phone' => '77009876542',
            'password' => bcrypt('Aa123123'),
        ]);

        $manager->roles()->attach($managerRoleId);

        $sellerRoleId = 3;

        $seller = User::create([
            'name' => 'Seller',
            'email' => 'seller@marketplace.com',
            'phone' => '77009876541',
            'password' => bcrypt('Aa123123'),
        ]);

        $seller->roles()->attach($sellerRoleId);
    }
}
