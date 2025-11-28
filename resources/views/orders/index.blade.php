@extends('layouts.app')

@section('content')
<style>
    .pedido-box {
        background: #0d1117;
        border: 1px solid #1f2937;
        padding: 20px;
        border-radius: 12px;
        color: #fff;
    }

    .titulo-pedidos {
        font-family: 'League Spartan', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: #52aaff;
        font-weight: 700;
        text-shadow: 0 0 6px #1b5f99;
        margin-bottom: 20px;
    }

    .pedido-box strong {
        color: #6ea8fe;
    }
</style>

<div class="container py-5">
    <h1 class="titulo-pedidos">Meus Pedidos 📦</h1>

    @if ($orders->isEmpty())
        <p class="text-light">Você ainda não possui pedidos.</p>
    @else
        @foreach ($orders as $order)
            <div class="pedido-box mb-4 shadow">
                <strong>Pedido #{{ $order->id }}</strong><br>
                Total: <span class="text-success">R$ {{ number_format($order->total, 2, ',', '.') }}</span><br>
                Data: {{ $order->created_at->format('d/m/Y H:i') }}

                <h4 class="mt-3 text-primary fw-bold">Itens:</h4>
                <ul>
                    @foreach ($order->items as $item)
                        <li>
                            {{ $item->product->name }} • 
                            Qtd: {{ $item->quantity }} • 
                            Preço: R$ {{ number_format($item->price, 2, ',', '.') }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @endif
</div>
@endsection
