<?php

namespace App\Services;

use App\Models\Burger;
use Illuminate\Session\SessionManager;

class CartService
{
    protected $session;
    protected $sessionKey = 'cart';

    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    public function getContent()
    {
        return $this->session->get($this->sessionKey, []);
    }

    public function add(Burger $burger, int $quantity = 1)
    {
        $cart = $this->getContent();
        
        if (isset($cart[$burger->id])) {
            $cart[$burger->id]['quantity'] += $quantity;
        } else {
            $cart[$burger->id] = [
                'name' => $burger->name,
                'price' => $burger->price,
                'quantity' => $quantity
            ];
        }

        $this->session->put($this->sessionKey, $cart);
    }

    public function remove($burgerId)
    {
        $cart = $this->getContent();
        unset($cart[$burgerId]);
        $this->session->put($this->sessionKey, $cart);
    }

    public function clear()
    {
        $this->session->forget($this->sessionKey);
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($this->getContent() as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
} 