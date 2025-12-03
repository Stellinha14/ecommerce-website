<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    // Página de checkout
    public function index()
    {
        $cart = Cart::session(Auth::id())->getContent();

        if ($cart->count() == 0) {
            return redirect()->route('carrinho.index')
                ->with('error', 'Seu carrinho está vazio.');
        }

        // Stripe
        $stripeKey = config('services.stripe.key');
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        // PaymentIntent
        $intent = \Stripe\PaymentIntent::create([
            'amount'   => intval(Cart::session(Auth::id())->getTotal() * 100),
            'currency' => 'brl',
        ]);

        return view('checkout.index', [
            'cart' => $cart,
            'stripeKey' => $stripeKey,
            'clientSecret' => $intent->client_secret,
        ]);
    }

    // Finaliza o pedido
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

            // Cria o pedido
            $order = Order::create([
                'user_id' => Auth::id(),
                'status'  => 'concluído',
                'total'   => $total,
            ]);

            // Salva todos os itens
            foreach ($cart as $item) {

                $filmeId  = $item->id;
                $price    = $item->price;
                $quantity = $item->quantity;

                if (!$filmeId) {
                    \Log::warning('Item sem ID no carrinho', ['item' => $item]);
                    continue;
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'filme_id' => $filmeId,
                    'quantity' => $quantity,
                    'price'    => $price,
                ]);
            }

            // Limpa carrinho
            Cart::session(Auth::id())->clear();

            return response()->json([
                'success' => true,
                'redirect' => route('orders.index')
            ]);

        } catch (\Exception $e) {

            \Log::error('Erro ao finalizar pedido', [
                'message' => $e->getMessage(),
                'cart'    => $cart ?? 'sem cart',
            ]);

            return response()->json([
                'error' => 'Falha ao salvar o pedido: ' . $e->getMessage()
            ], 500);
        }
    }
}
