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
                'price' => 8.99,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Cheese Burger',
                'description' => 'Steak haché, double cheddar, salade, tomate, oignon, sauce maison',
                'price' => 9.99,
                'stock' => 45,
                'is_active' => true,
            ],
            [
                'name' => 'Bacon Burger',
                'description' => 'Steak haché, bacon grillé, cheddar, salade, tomate, sauce barbecue',
                'price' => 10.99,
                'stock' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Veggie Burger',
                'description' => 'Galette de légumes, avocat, salade, tomate, oignon rouge, sauce végétarienne',
                'price' => 9.99,
                'stock' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Double Cheese',
                'description' => 'Double steak haché, triple cheddar, oignon caramélisé, sauce spéciale',
                'price' => 12.99,
                'stock' => 35,
                'is_active' => true,
            ],
            [
                'name' => 'Spicy Burger',
                'description' => 'Steak haché, piments jalapeños, cheddar épicé, salade, sauce piquante',
                'price' => 10.99,
                'stock' => 25,
                'is_active' => true,
            ],
        ];

        foreach ($burgers as $burger) {
            Burger::create($burger);
        }
    }
} 