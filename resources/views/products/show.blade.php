@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
            @else
                <img src="https://via.placeholder.com/600x400?text=Sem+Imagem" class="img-fluid" alt="Sem imagem">
            @endif
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <p>{{ $product->description }}</p>
            <h3 class="text-success">R$ {{ number_format($product->price, 2, ',', '.') }}</h3>
            <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Voltar ao Catálogo</a>
        </div>
    </div>
</div>
@endsection
