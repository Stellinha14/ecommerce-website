@extends('layouts.app')

@section('content')

<style>
      body {
        background: #06080c !important;
        color: #fff;
    }
    .form-card {
        background: #0b0e14;
        padding: 28px;
        border-radius: 14px;
        border: 1px solid rgba(80,150,255,0.18);
        box-shadow: 0 0 12px rgba(0,0,0,0.4);
        color: #dce9ff;
    }

    h1 {
        color: #52aaff;
        font-weight: 700;
        text-shadow: 0 0 6px #1b5f99;
    }

    label {
        color: #b8d4ff;
        font-weight: 600;
    }

    .form-control {
        background: #121821;
        border: 1px solid #1d2a3a;
        color: #dce9ff;
    }

    .form-control:focus {
        background: #161e2b;
        border-color: #4ea6ff;
        box-shadow: 0 0 8px rgba(78,166,255,0.4);
        color: white;
    }

    .btn-success {
        background: #2369b0;
        border: none;
        font-weight: bold;
    }

    .btn-success:hover {
        background: #2f7dcc;
    }

    .btn-secondary {
        background: #3c4757;
        border: none;
    }

    .btn-secondary:hover {
        background: #566277;
    }
</style>

<div class="container mt-5" style="max-width: 700px;">

    <h1 class="mb-4">Cadastrar Filme</h1>

    <div class="form-card">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('filmes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>Título</label>
                <input type="text" name="titulo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Descrição</label>
                <textarea name="descricao" class="form-control" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label>Categoria</label>
                <input type="text" name="categoria" class="form-control">
            </div>

            <div class="mb-3">
                <label>Ano</label>
                <input type="number" name="ano" class="form-control">
            </div> 

            <div class="mb-3">
                <label>Preço (R$)</label>
                <input type="number" name="preco" class="form-control" step="0.50" min="0" value="0">
            </div>

            <div class="mb-4">
                <label>Capa</label>
                <input type="file" name="capa" class="form-control" accept="image/*">
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('filmes.index') }}" class="btn btn-secondary">Cancelar</a>
                <button class="btn btn-success">Salvar Filme</button>
            </div>

        </form>

    </div>

</div>
@endsection
