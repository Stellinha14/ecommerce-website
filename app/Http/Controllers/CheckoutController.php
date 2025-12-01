<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        // 1. Verificar se o carrinho está vazio (melhor verificação)
        if (Cart::isEmpty()) {
            return redirect()->route('carrinho.index')
                ->with('error', 'Seu carrinho está vazio.');
        }
        
        Stripe::setApiKey(config('services.stripe.secret'));

        $total = Cart::getTotal();
        $amount = (int) ($total * 100); 

        // 2. A ÚNICA VERIFICAÇÃO DE VALOR TOTAL PERMITIDA: Valor muito alto
        if ($amount >= 99999999) { 
            return redirect()->route('carrinho.index')
                ->with('error', 'Valor muito alto! Esvazie o carrinho e tente novamente.');
        }

        // CORREÇÃO ESSENCIAL: Se o carrinho NÃO está vazio, o total DEVE ser maior que zero.
        // Se o total for zero (o que te faria recarregar), vamos parar e diagnosticar.
        if ($amount <= 0) {
            // Este redirecionamento deve acontecer apenas se o item tiver preço 0 no DB.
             return redirect()->route('carrinho.index')
                ->with('error', 'Erro no cálculo do carrinho. O valor total do seu pedido é zero ou negativo.');
        }


        $clientSecret = '';
        $stripeKey = config('services.stripe.key');

        try {
            $intent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'brl',
                'payment_method_types' => ['card'],
            ]);
            
            $clientSecret = $intent->client_secret;

        } catch (\Exception $e) {
             return redirect()->route('carrinho.index')
                ->with('error', 'Erro no Stripe (chaves inválidas?): ' . $e->getMessage());
        }
        
        return view('checkout.index', [
            'clientSecret' => $clientSecret,
            'stripeKey' => $stripeKey,
        ]);
    }

    public function store(Request $request)
    {
        // 1. Verificar se o carrinho está vazio
        $cartItems = Cart::getContent();
        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Carrinho vazio. Redirecionando...'], 400);
        }

        try {
            $order = auth()->user()->orders()->create([
                'total' => Cart::getTotal(),
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }

            Cart::clear();

            return response()->json([
                'success' => 'Pedido realizado!', 
                'redirect' => route('orders.index')
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Erro ao finalizar pedido: ' . $e->getMessage());
            return response()->json(['error' => 'Erro interno ao salvar o pedido: ' . $e->getMessage()], 500);
        }
    }
}