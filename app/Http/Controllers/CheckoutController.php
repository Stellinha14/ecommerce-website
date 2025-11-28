<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $total = Cart::getTotal();
        if ($total <= 0) {
            return redirect()->route('carrinho.index')->with('error', 'Seu carrinho está vazio.');
        }

        $amount = (int) ($total * 100); // centavos

        $intent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'brl',
            'payment_method_types' => ['card'],
        ]);

        return view('checkout.index', [
            'clientSecret' => $intent->client_secret,
            'stripeKey' => env('STRIPE_KEY'),
        ]);
    }

    public function store(Request $request)
    {
        $cartItems = Cart::getContent();

        if ($cartItems->isEmpty()) {
            return redirect()->route('carrinho.index')->with('error', 'Seu carrinho está vazio.');
        }

        $total = Cart::getTotal();

        $order = auth()->user()->orders()->create([
            'total' => $total,
        ]);

        foreach ($cartItems as $item) {
            $order->items()->create([
                'filme_id' => $item->id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        Cart::clear();

        return response()->json(['success' => true]);
    }
}
