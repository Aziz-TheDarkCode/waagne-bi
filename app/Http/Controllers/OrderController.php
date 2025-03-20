<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;
use App\Services\CartService;
use App\Mail\NewOrderNotification;
use App\Models\Burger;
// use PDF;


class OrderController extends Controller
{
    protected $orderService;
    protected $invoiceService;
    protected $cartService;

    public function __construct(OrderService $orderService, InvoiceService $invoiceService, CartService $cartService)
    {
        $this->orderService = $orderService;
        $this->invoiceService = $invoiceService;
        $this->cartService = $cartService;
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
            // Get cart items from session
            $cartItems = session('cart', []);
            
            if (empty($cartItems)) {
                return redirect()->route('cart.index')
                    ->with('error', 'Votre panier est vide.');
            }

            // Create the order
            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => 'pending',
                'total_amount' => $this->cartService->getTotal(),
            ]);

            // Create order items
            foreach ($cartItems as $burgerId => $item) {
                $order->items()->create([
                    'burger_id' => $burgerId,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                ]);

                // Update burger stock
                $burger = Burger::find($burgerId);
                if ($burger) {
                    $burger->decrement('stock', $item['quantity']);
                }
            }

            // Clear the cart
            session()->forget('cart');

            // Send email to admin
            $adminEmail = config('mail.admin_email', 'admin@example.com');
            Mail::to($adminEmail)->send(new NewOrderNotification($order));

            return redirect()->route('orders.show', $order)
                ->with('success', 'Votre commande a été créée avec succès.');
        } catch (\Exception $e) {
            \Log::error('Order creation failed: ' . $e->getMessage());
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

        // Send invoice if the order is ready
        if ($request->status === 'ready') {
            $this->invoiceService->generatePDF($order);
            Mail::to(auth()->user()->email)->send(new OrderConfirmation($order)); // Optionally send confirmation again
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Statut de la commande mis à jour avec succès.');
    }

    public function downloadInvoice(Order $order)
    {
        // Make sure the user can only download their own invoice or is an admin
        if (!auth()->user()->isAdmin() && auth()->id() !== $order->user_id) {
            abort(403);
        }

        $pdf = PDF::loadView('pdf.invoice', ['order' => $order]);
        
        return $pdf->download('facture-' . $order->id . '.pdf');
    }
} 