<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filme;
use Cart;

class CartController extends Controller
{
    // Mostra o carrinho
    public function index()
    {
        // Pega o carrinho da sessão do usuário logado
        $cart = Cart::session(auth()->id());
        return view('cart.cart', compact('cart'));
    }

    // Adiciona filme ao carrinho
    public function adicionar($id)
    {
        $filme = Filme::findOrFail($id);

        Cart::session(auth()->id())->add([
            'id' => $filme->id,
            'name' => $filme->titulo ?? 'Sem título',
            'price' => $filme->preco ?? 0,
            'quantity' => 1,
            'attributes' => [
                'capa' => $filme->capa ?? ''
            ]
        ]);

        return back()->with('success', 'Filme adicionado ao carrinho!');
    }

    // Remove item do carrinho
    public function remover($id)
    {
        Cart::session(auth()->id())->remove($id);
        return back()->with('success', 'Filme removido do carrinho.');
    }
}
