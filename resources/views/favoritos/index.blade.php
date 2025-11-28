<x-app-layout>
    <div class="container py-5">
        <h2 class="text-white mb-4">❤️ Meus Favoritos</h2>

        @if($favoritos->count() === 0)
            <p class="text-light">Você ainda não favoritou nenhum filme.</p>
        @endif

        <div class="row">
            @foreach ($favoritos as $filme)
                <div class="col-md-3 mb-4">
                    <div class="card bg-dark text-white">
                        <img src="{{ asset('storage/' . $filme->capa) }}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{ $filme->titulo }}</h5>
                            <a href="{{ route('filme.favorito', $filme->id) }}"
                               onclick="event.preventDefault(); document.getElementById('fav-{{ $filme->id }}').submit();"
                               style="font-size: 20px;">
                                ❤️ Remover
                            </a>
                            <form id="fav-{{ $filme->id }}" action="{{ route('filme.favorito', $filme->id) }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
