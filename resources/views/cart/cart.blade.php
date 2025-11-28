@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Meu Carrinho 🎬</h1>

    @php
        $cart = Cart::session(auth()->id());
    @endphp

    @if($cart->getContent()->count() > 0)
        <table class="table table-dark table-hover">
            <thead>
                <tr>
                    <th>Filme</th>
                    <th>Capa</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Subtotal</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart->getContent() as $item)
                    <tr>
                        <td>{{ $item->name }}</td>

                        {{-- CAPA --}}
                        <td>
                            @if($item->attributes->capa)
                                <img src="{{ asset('storage/' . $item->attributes->capa) }}" 
                                     alt="capa" 
                                     width="70"
                                     class="rounded">
                            @else
                                <img src="https://via.placeholder.com/70x100?text=Sem+Capa" 
                                     alt="Sem capa" 
                                     class="rounded">
                            @endif
                        </td>

                        <td>{{ $item->quantity }}</td>
                        <td>R$ {{ number_format($item->price, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($item->quantity * $item->price, 2, ',', '.') }}</td>

                        {{-- BOTÃO REMOVER --}}
                        <td>
                            <form action="{{ route('carrinho.remover', $item->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-sm">Remover</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="4" class="text-end fw-bold">Total:</td>
                    <td class="fw-bold">
                        R$ {{ number_format($cart->getTotal(), 2, ',', '.') }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <a href="{{ route('checkout.index') }}" class="btn btn-success">Finalizar Compra</a>

    @else
        <p>Seu carrinho está vazio.</p>
        <a href="{{ route('filmes.index') }}" class="btn btn-secondary">Ver Filmes</a>
    @endif
</div>
@endsection
