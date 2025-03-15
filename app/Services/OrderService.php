<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Burger;
use Illuminate\Support\Facades\DB;
use App\Exceptions\InsufficientStockException;

class OrderService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function createFromCart()
    {
        $cartItems = $this->cartService->getContent();
        
        if (empty($cartItems)) {
            throw new \Exception('Le panier est vide');
        }

        return DB::transaction(function () use ($cartItems) {
            // Vérifier le stock pour chaque burger
            foreach ($cartItems as $burgerId => $item) {
                $burger = Burger::find($burgerId);
                if ($burger->stock < $item['quantity']) {
                    throw new InsufficientStockException("Stock insuffisant pour {$burger->name}");
                }
            }

            // Créer la commande
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $this->cartService->getTotal(),
                'status' => 'pending'
            ]);

            // Ajouter les items et mettre à jour le stock
            foreach ($cartItems as $burgerId => $item) {
                $burger = Burger::find($burgerId);
                $order->items()->create([
                    'burger_id' => $burgerId,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price']
                ]);

                $burger->decrement('stock', $item['quantity']);
            }

            // Vider le panier
            $this->cartService->clear();

            return $order;
        });
    }
} 