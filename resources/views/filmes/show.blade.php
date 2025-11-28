@extends('layouts.app')

@section('content')

<style>
      body {
        background: #06080c !important;
        color: #fff;
    }
    h1 {
        color: #52aaff;
        font-weight: 700;
        text-shadow: 0 0 6px #1b5f99;
    }

    .info-box {
        background: #0b0e14;
        padding: 24px;
        border-radius: 14px;
        border: 1px solid rgba(80,150,255,0.15);
        color: #dce9ff;
        box-shadow: 0 0 14px rgba(0,0,0,0.45);
    }

    .text-muted {
        color: #9ab4d7 !important;
    }

    .price {
        color: #7ac1ff;
        font-size: 1.4rem;
        font-weight: bold;
        text-shadow: 0 0 8px #0c2c47;
    }

    .btn-warning {
        background: #3db6c0;
        border: none;
        color: #001a21;
        font-weight: bold;
    }
    .btn-warning:hover {
        background: #54d0da;
    }

    .btn-secondary {
        background: #3c4757;
        border: none;
    }
    .btn-secondary:hover {
        background: #566277;
    }
</style>

<div class="container mt-5">

    <div class="row g-4">
        
        <div class="col-md-5">
            @if($filme->capa)
                <img src="{{ asset('storage/' . $filme->capa) }}" class="img-fluid rounded shadow">
            @else
                <img src="https://via.placeholder.com/600x400?text=Sem+Capa"
                     class="img-fluid rounded shadow">
            @endif
        </div>

        <div class="col-md-7">
            
            <div class="info-box">
                <h1>{{ $filme->titulo }}</h1>

                <p class="text-muted">{{ $filme->categoria }} • {{ $filme->ano }}</p>

                <p class="price">R$
                    {{ number_format($filme->preco, 2, ',', '.') }}
                </p>

                <p class="mt-3">{{ $filme->descricao }}</p>

                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('filmes.edit', $filme->id) }}" class="btn btn-warning">Editar</a>
                    <a href="{{ route('filmes.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
