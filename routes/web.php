<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Routes d'authentification
require __DIR__.'/auth.php';

// Routes publiques
Route::get('/', function () {
    return redirect()->route('burgers.index');
});

// Routes authentifiées
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Panier
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{burger}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{burger}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{burger}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Commandes client
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update.status');
    
    // Invoice download
    Route::get('/orders/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice.download');

    // Make burgers.index the main dashboard
    Route::get('/dashboard', function () {
        return redirect()->route('burgers.index');
    })->name('dashboard');

    // Burgers routes
    Route::get('/menu', [BurgerController::class, 'index'])->name('burgers.index');
});

// Routes administrateur
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Tableau de bord
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Gestion des burgers - Notez l'ordre des routes !
    Route::get('/burgers/create', [BurgerController::class, 'create'])->name('burgers.create');
    Route::post('/burgers', [BurgerController::class, 'store'])->name('burgers.store');
    Route::get('/burgers/{burger}/edit', [BurgerController::class, 'edit'])->name('burgers.edit');
    Route::patch('/burgers/{burger}', [BurgerController::class, 'update'])->name('burgers.update');
    Route::delete('/burgers/{burger}', [BurgerController::class, 'destroy'])->name('burgers.destroy');
    
    // Gestion des commandes admin
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update.status');
    Route::post('/orders/{order}/payment', [OrderController::class, 'registerPayment'])->name('admin.orders.payment');
});

// Route pour afficher un burger spécifique (doit être après les routes admin)
Route::get('/burgers/{burger}', [BurgerController::class, 'show'])->name('burgers.show');

// Fallback route
Route::fallback(function () {
    return redirect()->route('home');
});
