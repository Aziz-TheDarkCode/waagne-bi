<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getContent();
        $total = $this->cartService->getTotal();
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Burger $burger)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:'.$burger->stock
        ]);

        $this->cartService->add($burger, $validated['quantity']);

        return response()->json([
            'message' => 'Burger ajouté au panier',
            'cartTotal' => $this->cartService->getTotal()
        ]);
    }

    public function remove(Burger $burger)
    {
        $this->cartService->remove($burger->id);
        
        return redirect()->route('cart.index')
            ->with('success', 'Burger retiré du panier');
    }

    public function clear()
    {
        $this->cartService->clear();
        
        return redirect()->route('cart.index')
            ->with('success', 'Panier vidé');
    }
} 