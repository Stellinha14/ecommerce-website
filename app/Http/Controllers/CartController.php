<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filme; // Model correto
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CartController extends Controller
{
    /**
     * Exibe o conteúdo do carrinho para o usuário logado.
     * Deve retornar a view 'cart.index'.
     */
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar o carrinho.');
        }

        // Obtém o conteúdo do carrinho usando o ID do usuário como sessão
        $cartItems = Cart::session(auth()->id())->getContent();
        
        // CORRIGIDO: Assume que o arquivo Blade é 'resources/views/cart/index.blade.php'
        return view('cart.index', compact('cartItems'));
    }

    /**
     * Adiciona um filme ao carrinho de compras do usuário.
     */
    public function addToCart(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para adicionar ao carrinho.');
        }

        $filme = Filme::find($id);
        if (!$filme) {
            return redirect()->back()->with('error', 'Filme não encontrado!');
        }

        // Adiciona o item à sessão do carrinho do usuário
        Cart::session(auth()->id())->add([
            'id' => $filme->id,
            'name' => $filme->titulo,
            'price' => $filme->preco,
            'quantity' => 1,
            'attributes' => [
                'image' => $filme->capa
            ]
        ]);

        return redirect()->route('carrinho.index')->with('success', 'Filme adicionado ao carrinho!');
    }

    /**
     * Atualiza a quantidade de um item no carrinho.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        Cart::session(auth()->id())->update($id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity
            ],
        ]);

        return redirect()->route('carrinho.index')->with('success', 'Quantidade atualizada no carrinho!');
    }

    /**
     * Remove um item específico do carrinho.
     */
    public function remove($id)
    {
        Cart::session(auth()->id())->remove($id);

        return redirect()->route('carrinho.index')->with('success', 'Filme removido do carrinho!');
    }
}