@extends('layouts.app')

@section('content')
<div class="container text-center py-5">

    {{-- Nome da loja --}}
    <h1 class="display-4 mb-3">Bem-vindo à Minha Loja</h1>

    {{-- Chamada principal --}}
    <p class="lead mb-4">Confira nossos produtos incríveis com os melhores preços!</p>

    {{-- Botão para ir para o catálogo --}}
    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Ver Produtos</a>
</div>
@endsection
