<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Burger;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $stats = [
            'total_sales' => Order::where('status', 'paid')
                ->sum('total_amount'),
            'orders_today' => Order::whereDate('created_at', Carbon::today())
                ->count(),
            'pending_orders' => Order::where('status', 'pending')
                ->count(),
            'low_stock_items' => Burger::where('stock', '<', 10)
                ->where('is_active', true)
                ->count(),
        ];

        // Ventes des 7 derniers jours
        $dailySales = Order::where('status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->get();

        // Burgers les plus vendus
        $topBurgers = DB::table('order_items')
            ->join('burgers', 'order_items.burger_id', '=', 'burgers.id')
            ->select('burgers.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('burgers.id', 'burgers.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Commandes récentes
        $recentOrders = Order::with(['user', 'items.burger'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'dailySales',
            'topBurgers',
            'recentOrders'
        ));
    }
} 