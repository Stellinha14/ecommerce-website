<x-app-layout class="bg-black">

<style>
body.dashboard-body {
    background: #000 !important;
    color: white !important;
    font-family: 'League Spartan', sans-serif;
}

.titulo-secao {
    text-align: center;
    font-size: 2rem;
    font-weight: 700;
    margin-top: 25px;
    margin-bottom: 10px;
}

.carrossel-wrapper {
    position: relative;
    width: 100%;
    overflow: hidden;
    padding: 20px 0;
}

.carrossel {
    display: flex;
    gap: 25px;
    transition: transform 0.3s ease-in-out;
}

.filme-card {
    flex: 0 0 calc((100% - 75px) / 4); /* 4 colunas + gap */
    height: 400px;
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    transition: 0.3s;
    display: flex;
    flex-direction: column;
}

.filme-card img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    position: relative;
    filter: brightness(60%);
    transition: 0.3s;
}

.filme-card:hover img {
    transform: scale(1.05);
    filter: brightness(80%);
}

.filme-info {
    padding: 10px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    position: absolute;
    top: 60%;
    gap: 5px;
    flex-grow: 1;
}

.filme-titulo {
    font-size: 1.1rem;
    font-weight: 700;
}

.filme-ano, .filme-categoria, .filme-preco {
    font-size: 0.9rem;
    color: #ccc;
}

.card-icons {
    display: flex;
    position: absolute;
    top: 90%;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}

.card-icons button {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: white;
    text-shadow: 0px 0px 8px black;
}

.card-icons button:hover {
    transform: scale(1.2);
    transition: 0.2s;
}

/* Seta */
.seta {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 2rem;
    cursor: pointer;
    color: white;
    z-index: 10;
    user-select: none;
}

.seta-esquerda { left: 10px; }
.seta-direita { right: 10px; }
</style>

<h2 class="titulo-secao">🎬 Nossos Filmes</h2>

<div class="carrossel-wrapper">
    <div class="seta seta-esquerda" onclick="moverCarrossel(-1)">‹</div>
    <div class="seta seta-direita" onclick="moverCarrossel(1)">›</div>

    <div id="carrossel" class="carrossel">
        @foreach ($filmes as $filme)
            <div class="filme-card">
                <img src="{{ asset('storage/' . $filme->capa) }}" alt="{{ $filme->titulo }}">

                <div class="filme-info">
                    <div class="filme-titulo">{{ $filme->titulo }}</div>
                    <div class="filme-ano"><strong>Ano:</strong> {{ $filme->ano }}</div>
                    <div class="filme-categoria"><strong>Categoria:</strong> {{ $filme->categoria }}</div>
                    <div class="filme-preco"><strong>Preço:</strong> R$ {{ number_format($filme->preco, 2, ',', '.') }}</div>
                </div>

                <div class="card-icons">
                    {{-- ❤️ Favorito --}}
                    <form action="{{ route('filme.favorito', $filme->id) }}" method="POST">
                        @csrf
                        <button type="submit">
                            @if(auth()->check() && auth()->user()->favorites()->where('filme_id', $filme->id)->exists())
                                ❤️
                            @else
                                🤍
                            @endif
                        </button>
                    </form>

                    {{-- 🛒 Carrinho --}}
                    <form action="{{ route('carrinho.adicionar', $filme->id) }}" method="POST">
                        @csrf
                        <button type="submit">🛒</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
let indice = 0;
const carrossel = document.getElementById('carrossel');
const totalCards = carrossel.children.length;
const cardsVisiveis = 4;

function moverCarrossel(direcao) {
    indice += direcao;
    if (indice < 0) indice = 0;
    if (indice > totalCards - cardsVisiveis) indice = totalCards - cardsVisiveis;

    const cardWidth = carrossel.children[0].offsetWidth + 25;
    carrossel.style.transform = `translateX(-${indice * cardWidth}px)`;
}
</script>

</x-app-layout>
