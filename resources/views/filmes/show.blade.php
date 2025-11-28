@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <div class="row">
        <div class="col-md-5">

            @if($filme->capa)
                <img src="{{ asset('storage/' . $filme->capa) }}" class="img-fluid rounded">
            @else
                <img src="https://via.placeholder.com/600x400?text=Sem+Capa" class="img-fluid rounded">
            @endif

        </div>

        <div class="col-md-7">
            <h1>{{ $filme->titulo }}</h1>
            <p class="text-muted">{{ $filme->categoria }} • {{ $filme->ano }}</p>
            <p class="text-success fw-bold">R$ {{ number_format($filme->preco, 2, ',', '.') }}</p>

            <p class="mt-3">{{ $filme->descricao }}</p>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('filmes.edit', $filme->id) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('filmes.index') }}" class="btn btn-secondary">Voltar</a>
            </div>

        </div>
    </div>

</div>
@endsection
