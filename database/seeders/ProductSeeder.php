<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create(['name' => 'Product 1', 'price' => 19.99]);
        Product::create(['name' => 'Product 2', 'price' => 29.99]);
        Product::create(['name' => 'Product 3', 'price' => 39.99]);
    }
}

