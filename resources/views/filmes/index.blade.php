@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1200px;">

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1>Catálogo de Filmes</h1>
        <a href="{{ route('filmes.create') }}" class="btn btn-success">+ Novo Filme</a>
    </div>

    <div class="row">
        @forelse($filmes as $filme)
            <div class="col-md-4 mb-4">
                <div class="card h-100">

                    @if($filme->capa)
                        <img src="{{ asset('storage/' . $filme->capa) }}" class="card-img-top" alt="{{ $filme->titulo }}">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=Sem+Capa" class="card-img-top">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $filme->titulo }}</h5>
                        <p class="text-muted">
                            {{ $filme->categoria }} • {{ $filme->ano }}
                        </p>
                        <p class="text-success fw-bold">R$ {{ number_format($filme->preco, 2, ',', '.') }}</p>
                        <a href="{{ route('filmes.show', $filme->id) }}" class="btn btn-primary w-100">Ver Detalhes</a>
                    </div>


                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('filmes.edit', $filme->id) }}" class="btn btn-warning btn-sm">Editar</a>

                        <form action="{{ route('filmes.destroy', $filme->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Deseja realmente excluir?')">Excluir</button>
                        </form>
                    </div>

                </div>
            </div>
        @empty
            <p>Nenhum filme encontrado.</p>
        @endforelse
    </div>
</div>
@endsection
