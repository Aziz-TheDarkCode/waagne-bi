<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\Burger;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer tous les utilisateurs non-admin
        $users = User::where('role', 'user')->get();
        $burgers = Burger::all();
        $statuses = ['pending', 'preparing', 'ready', 'paid'];

        // Créer 50 commandes
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $orderDate = Carbon::now()->subDays(rand(0, 30));
            
            // Créer la commande
            $order = Order::create([
                'user_id' => $user->id,
                'status' => $statuses[array_rand($statuses)],
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
                'total_amount' => 0,
            ]);

            // Ajouter 1 à 4 burgers à la commande
            $totalAmount = 0;
            $numberOfItems = rand(1, 4);
            
            $orderBurgers = $burgers->random($numberOfItems);
            foreach ($orderBurgers as $burger) {
                $quantity = rand(1, 3);
                $order->items()->create([
                    'burger_id' => $burger->id,
                    'quantity' => $quantity,
                    'unit_price' => $burger->price,
                ]);
                $totalAmount += $burger->price * $quantity;
            }

            // Mettre à jour le montant total
            $order->update([
                'total_amount' => $totalAmount,
                'paid_at' => $order->status === 'paid' ? $orderDate : null,
            ]);
        }
    }
} 