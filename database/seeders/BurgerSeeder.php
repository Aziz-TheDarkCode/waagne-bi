<?php

namespace Database\Seeders;

use App\Models\Burger;
use Illuminate\Database\Seeder;

class BurgerSeeder extends Seeder
{
    public function run(): void
    {
        $burgers = [
            [
                'name' => 'Classic Burger',
                'description' => 'Steak haché, salade, tomate, oignon, sauce maison',
                'price' => 1000,
                'stock' => 50,
                "image_path" => "https://taplink.st/p/3/e/a/7/63594291.jpg",
                'is_active' => true,
            ],
            [
                'name' => 'Cheese Burger',
                'description' => 'Steak haché, double cheddar, salade, tomate, oignon, sauce maison',
                'price' => 1800,
                'stock' => 45,
                "image_path" => "https://taplink.st/p/3/e/a/7/63594291.jpg",

                'is_active' => true,
            ],
            [
                'name' => 'Bacon Burger',
                'description' => 'Steak haché, bacon grillé, cheddar, salade, tomate, sauce barbecue',
                'price' => 2500,
                'stock' => 40,
                "image_path" => "https://taplink.st/p/3/e/a/7/63594291.jpg",

                'is_active' => true,
            ],
            [
                'name' => 'Veggie Burger',
                'description' => 'Galette de légumes, avocat, salade, tomate, oignon rouge, sauce végétarienne',
                'price' => 1500,
                'stock' => 30,
                "image_path" => "https://taplink.st/p/3/e/a/7/63594291.jpg",

                'is_active' => true,
            ],
            [
                'name' => 'Double Cheese',
                'description' => 'Double steak haché, triple cheddar, oignon caramélisé, sauce spéciale',
                'price' => 2000,
                'stock' => 35,
                "image_path" => "https://taplink.st/p/3/e/a/7/63594291.jpg",

                'is_active' => true,
            ],
            [
                'name' => 'Spicy Burger',
                'description' => 'Steak haché, piments jalapeños, cheddar épicé, salade, sauce piquante',
                'price' => 3000,
                'stock' => 25,
                "image_path" => "https://taplink.st/p/3/e/a/7/63594291.jpg",

                'is_active' => true,
            ],
        ];

        foreach ($burgers as $burger) {
            Burger::create($burger);
        }
    }
} 