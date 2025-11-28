<x-app-layout>
<style>
        body {
        background: #06080c !important;
        color: #fff;
    }
    .fav-card {
        background: #0d1117 !important;
        border: 1px solid #1f2937;
        border-radius: 12px;
        transition: 0.2s;
    }

    .fav-card:hover {
        transform: scale(1.03);
    }
    h1{
        font-family: 'League Spartan', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: #52aaff;
        text-shadow: 0 0 6px #1b5f99;
    }
    .fav-title {
        font-weight: bold;
        color: #fff;
    }

    .fav-remove {
        font-size: 18px;
        color: #ff6b81;
        text-decoration: none;
    }

    .fav-remove:hover {
        color: #ff8799;
    }
</style>

<div class="container py-5">
    <h1 class=" mb-4">Meus Favoritos ❤️</h1>

    @if($favoritos->count() === 0)
        <p class="text-light">Você ainda não favoritou nenhum filme.</p>
    @endif

    <div class="row">
        @foreach ($favoritos as $filme)
            <div class="col-md-3 mb-4">
                <div class="card fav-card">
                    <img src="{{ asset('storage/' . $filme->capa) }}" class="card-img-top">

                    <div class="card-body">
                        <h5 class="fav-title">{{ $filme->titulo }}</h5>

                        <a href="{{ route('filme.favorito', $filme->id) }}"
                           onclick="event.preventDefault(); document.getElementById('fav-{{ $filme->id }}').submit();"
                           class="fav-remove">
                           ❤️ Remover
                        </a>

                        <form id="fav-{{ $filme->id }}" action="{{ route('filme.favorito', $filme->id) }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</x-app-layout>
