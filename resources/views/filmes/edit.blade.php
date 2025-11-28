@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width: 700px;">

    <h1 class="mb-4">Editar Filme</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('filmes.update', $filme->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $filme->titulo) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" rows="4">{{ old('descricao', $filme->descricao) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Categoria</label>
            <input type="text" name="categoria" class="form-control" value="{{ old('categoria', $filme->categoria) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Ano</label>
            <input type="number" name="ano" class="form-control" value="{{ old('ano', $filme->ano) }}">
        </div> 

        <div class="mb-3">
            <label class="form-label">Preço (R$)</label>
            <input type="number" name="preco" class="form-control" step="0.01" min="0" 
                   value="{{ old('preco', $filme->preco) }}" required>
        </div>

        <div class="mb-4">
            <label class="form-label">Capa</label>
            <input type="file" name="capa" class="form-control" accept="image/*">
            @if($filme->capa)
                <img src="{{ asset('storage/' . $filme->capa) }}" alt="{{ $filme->titulo }}" class="img-fluid mt-2" style="max-height: 200px;">
            @endif
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('filmes.index') }}" class="btn btn-secondary">Cancelar</a>
            <button class="btn btn-success">Atualizar Filme</button>
        </div>
    </form>

</div>
@endsection
