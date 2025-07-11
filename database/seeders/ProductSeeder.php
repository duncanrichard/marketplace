<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Sepatu Sneakers',
            'description' => 'Sepatu nyaman untuk sehari-hari.',
            'price' => 350000
        ]);

        Product::create([
            'name' => 'Kaos Polos',
            'description' => 'Kaos katun kualitas premium.',
            'price' => 75000
        ]);

        Product::create([
            'name' => 'Jam Tangan Digital',
            'description' => 'Jam tahan air dengan fitur stopwatch.',
            'price' => 250000
        ]);
    }
}
