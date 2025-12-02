<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart; 
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    // Exibe a página de checkout
    public function index()
    {
        $cart = Cart::session(Auth::id())->getContent();

        if ($cart->count() == 0) {
            return redirect()->route('carrinho.index')
                ->with('error', 'Seu carrinho está vazio.');
        }

        // PEGAR CHAVE PÚBLICA DO STRIPE
        $stripeKey = config('services.stripe.key');

        // CRIAR PAYMENT INTENT PARA PEGAR O client_secret
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $intent = \Stripe\PaymentIntent::create([
            'amount'   => intval(Cart::session(Auth::id())->getTotal() * 100), // valor em centavos
            'currency' => 'brl',
        ]);

        $clientSecret = $intent->client_secret;

        return view('checkout.index', compact('cart', 'stripeKey', 'clientSecret'));
    }

    // Finaliza o pedido após pagamento aprovado
    public function store(Request $request)
    {
        try {
            $cart = Cart::session(Auth::id())->getContent();

            if ($cart->count() == 0) {
                return response()->json([
                    'error' => 'Seu carrinho está vazio.'
                ], 400);
            }

            $total = Cart::session(Auth::id())->getTotal();

            $order = Order::create([
                'user_id' => Auth::id(),
                'status'  => 'concluído',
                'total'   => $total,
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'filme_id' => $item->id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->price,
                ]);
            }

            Cart::session(Auth::id())->clear();

            // RETORNA JSON com redirect para JS
            return response()->json([
                'success' => true,
                'redirect' => route('orders.index')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
