<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['items.burger'])
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Vérifier que l'utilisateur peut voir cette commande
        if (auth()->id() !== $order->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $order->load(['items.burger', 'user']);
        
        return view('orders.show', compact('order'));
    }
    public function downloadPdf(Order $order)
    {
        // Ensure the user has access to this order
        if (auth()->id() !== $order->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        // Load the order data
        $order->load(['items.burger', 'user']);

        // Generate the PDF
        $pdf = PDF::loadView('orders.pdf', compact('order'));

        // Download the PDF
        return $pdf->download('commande_' . $order->id . '.pdf');
    }
    public function store(Request $request)
    {
        try {
            $order = $this->orderService->createFromCart();
            
            return redirect()->route('orders.show', $order)
                ->with('success', 'Commande créée avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('cart.index')
                ->with('error', 'Une erreur est survenue lors de la création de la commande.');
        }
    }

    public function adminIndex()
    {
        $orders = Order::with(['user', 'items.burger'])
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,ready,paid',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Statut de la commande mis à jour avec succès.');
    }
} 