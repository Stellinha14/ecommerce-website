<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Filmes (acesso aberto)
Route::resource('filmes', FilmeController::class);

// Middleware auth
Route::middleware('auth')->group(function () {

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Favoritos
    Route::post('/filme/{id}/favorito', [FavoritoController::class, 'toggle'])
        ->name('filme.favorito');
    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos.index');

    // Histórico de pedidos
    Route::get('/meus-pedidos', [OrderController::class, 'index'])->name('orders.index');

    // Carrinho
    Route::get('/cart', [CartController::class, 'index'])->name('carrinho.index');
    Route::post('/cart/add/{id}', [CartController::class, 'adicionar'])->name('carrinho.adicionar');
    Route::post('/cart/remove/{id}', [CartController::class, 'remover'])->name('carrinho.remover');

    // Checkout finalização
      Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
});

// Tela de checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

require __DIR__.'/auth.php';
