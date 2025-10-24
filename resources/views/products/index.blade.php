@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1200px;">

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Título + Botão --}}
    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
        <h1>Catálogo de Produtos</h1>
        <a href="{{ route('products.create') }}" class="btn btn-success">+ Novo Produto</a>
    </div>

    {{-- Lista de produtos --}}
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100" style="max-width: 100%;">
                    {{-- Imagem --}}
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top fixed-img" alt="{{ $product->name }}">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=Sem+Imagem" class="card-img-top fixed-img" alt="Sem imagem">
                    @endif

                    {{-- Corpo do card --}}
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="h5 mb-0">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                            <div>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-half text-warning"></i>
                                <small class="text-muted">(4.5)</small>
                            </div>
                        </div>

                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary mb-2">Ver Produto</a>
                    </div>

                    {{-- Rodapé do card --}}
                    <div class="card-footer d-flex justify-content-between bg-light">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-flex align-items-center gap-2">
                            @csrf
                            <input type="number" name="quantity" min="1" value="1" class="form-control form-control-sm" style="max-width: 80px;">
                            <button type="submit" class="btn btn-success btn-sm">Adicionar ao Carrinho</button>
                        </form>
                        <button class="btn btn-outline-secondary btn-sm like-btn" type="button">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                </div>
            </div>
        @empty
            <p>Nenhum produto encontrado.</p>
        @endforelse
    </div>
</div>

{{-- Script para alternar o coração --}}
<script>
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', () => {
            const icon = button.querySelector('i');
            if (icon.classList.contains('bi-heart')) {
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
                button.classList.remove('btn-outline-secondary');
                button.classList.add('btn-danger');
            } else {
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
                button.classList.remove('btn-danger');
                button.classList.add('btn-outline-secondary');
            }
        });
    });
</script>

@endsection
