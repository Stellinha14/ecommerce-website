@extends('layouts.app')

@section('content')
<style>
    body {
        background: #06080c !important;
        color: #fff;
    }
    .titulo-carrinho {
        font-family: 'League Spartan', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: #52aaff; /* Ajustei a cor para combinar com o tema */
        text-shadow: 0 0 6px #1b5f99;
    }

    .table-dark {
        background: #0b0f16 !important;
        color: #fff !important;
        border-radius: 10px;
        overflow: hidden;
    }

    .table-dark thead {
        background: #111827 !important;
    }

    .btn-remove {
        background: #cf2f4f;
        border: none;
    }

    .btn-remove:hover {
        background: #ff4d6d;
    }

    .btn-finalizar {
        background: #2b5df5;
        border: none;
        padding: 10px 20px;
        font-weight: bold;
    }

    .btn-finalizar:hover {
        background: #5685ff;
    }
</style>

<div class="container py-5">
    <h1 class="titulo-carrinho mb-4">Meu Carrinho 🎬</h1>

    @php
        // Acesso ao carrinho na View é válido
        $cart = Cart::session(auth()->id());
    @endphp

    @if($cart->getContent()->count() > 0)

        <table class="table table-dark table-hover">
            <thead>
                <tr>
                    <th>Filme</th>
                    <th>Capa</th>
                    <th>Qtd</th>
                    <th>Preço</th>
                    <th>Subtotal</th>
                    <th>Ação</th>
                </tr>
            </thead>

            <tbody>
                @foreach($cart->getContent() as $item)
                    <tr>
                        <td>{{ $item->name }}</td>

                        <td>
                            {{-- CORREÇÃO AQUI: Usando 'image', que é a chave correta salva pelo Controller --}}
                            @php
                                $capaPath = $item->attributes->get('image');
                            @endphp
                            
                            @if($capaPath)
                                <img src="{{ asset('storage/' . $capaPath) }}" width="65" class="rounded">
                            @else
                                <img src="https://via.placeholder.com/70x100?text=Sem+Capa" class="rounded">
                            @endif
                        </td>

                        <td>{{ $item->quantity }}</td>
                        <td>R$ {{ number_format($item->price, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($item->quantity * $item->price, 2, ',', '.') }}</td>

                        <td>
                            {{-- Rota corrigida para 'carrinho.remove' --}}
                            <form action="{{ route('carrinho.remove', $item->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-remove btn-sm text-white">Remover</button>
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

        <a href="{{ route('checkout.index') }}" class="btn btn-finalizar text-white">Finalizar Compra</a>

    @else
        <p class="text-light">Seu carrinho está vazio.</p>
        <a href="{{ route('filmes.index') }}" class="btn btn-secondary">Ver Filmes</a>
    @endif
</div>
@endsection