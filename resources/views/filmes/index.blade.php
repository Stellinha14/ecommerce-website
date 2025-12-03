@extends('layouts.app')

@section('content')

<style>
    body {
        background: #06080c !important;
        color: #fff;
    }

    h1.tile {
        color: #52aaff;
        font-weight: 700;
        text-shadow: 0 0 6px #1b5f99;
    }

    @media (min-width: 992px) {
        .filmes-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }
    }

    .card {
        position: relative;
        height: 380px;
        background: #0b0e14;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(80, 150, 255, 0.15);
        transition: .3s;
    }

    .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 0 18px rgba(80, 150, 255, 0.25);
    }

    .card-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.65);
        transition: .3s;
    }

    .card:hover .card-img {
        filter: brightness(0.85);
    }

    .card-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        padding: 18px;
        width: 100%;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.85), transparent);
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #dce9ff;
        text-shadow: 0 0 8px rgba(0,0,0,0.6);
    }

    .card-info {
        color: #c6d8f5;
        font-size: 0.9rem;
        margin-bottom: 6px;
    }

    .card-price {
        color: #7ac1ff;
        font-weight: bold;
        margin-bottom: 10px;
        text-shadow: 0 0 6px #0c2c47;
    }

    .btn-primary {
        background: #143a63;
        border: none;
        font-weight: bold;
    }

    .btn-primary:hover {
        background: #195083;
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

    .btn-danger {
        background: #521f2f;
        border: none;
        color: #fff;
    }

    .btn-danger:hover {
        background: #74293f;
    }

    .btn-success {
        background: #2369b0;
        border: none;
        font-weight: bold;
    }
</style>

<div class="container py-4" style="max-width: 1300px;">

    <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
        <h1 class="tile">Catálogo de Filmes</h1>
        <a href="{{ route('filmes.create') }}" class="btn btn-success">+ Novo Filme</a>
    </div>

    <div class="filmes-grid">

        @forelse($filmes as $filme)

        <div>
            <div class="card">

                @php
                    $imgSeed = public_path('img/' . $filme->capa);
                    $imgUpload = 'storage/filmes/' . $filme->capa;
                @endphp

                @if($filme->capa && file_exists($imgSeed))
                    <img src="{{ asset('img/' . $filme->capa) }}" class="card-img" alt="{{ $filme->titulo }}">
                @elseif($filme->capa)
                        <img src="{{ asset('storage/' . $filme->capa) }}" class="img-fluid rounded shadow">
                @else
                    <img src="https://via.placeholder.com/400x600?text=Sem+Capa" class="card-img">
                @endif

                <div class="card-overlay">
                    <h5 class="card-title">{{ $filme->titulo }}</h5>
                    <p class="card-info">
                        {{ $filme->categoria }} • {{ $filme->ano }}
                    </p>
                    <p class="card-price">
                        R$ {{ number_format($filme->preco, 2, ',', '.') }}
                    </p>
                    <a href="{{ route('filmes.show', $filme->id) }}" class="btn btn-primary w-100 mb-2">
                        Ver Detalhes
                    </a>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-2">
                <a href="{{ route('filmes.edit', $filme->id) }}" class="btn btn-warning btn-sm px-3">
                    Editar
                </a>

                <form action="{{ route('filmes.destroy', $filme->id) }}" method="POST" class="m-0">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm px-3" onclick="return confirm('Deseja realmente excluir?')">
                        Excluir
                    </button>
                </form>
            </div>

        </div>

        @empty
            <p>Nenhum filme encontrado.</p>
        @endforelse

    </div>
</div>

@endsection
