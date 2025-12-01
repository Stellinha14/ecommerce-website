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

    // Carrinho (Rotas corrigidas e completas)
    Route::get('/cart', [CartController::class, 'index'])->name('carrinho.index');
    // ROTA PARA ADICIONAR ITEM. O nome CORRETO é 'carrinho.add'
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('carrinho.add');
    // Adicionada rota de atualização, presente no seu CartController
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('carrinho.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('carrinho.remove');


    // Checkout finalização
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
});

// A rota de checkout já foi definida dentro do grupo 'auth', removida a duplicação.

require __DIR__.'/auth.php';