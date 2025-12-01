<x-app-layout class="bg-black">

<style>
    body {
        background: #05060a !important;
        color: #fff;
        font-family: 'League Spartan', sans-serif;
    }

    .titulo-secao {
        text-align: start;
        font-size: 2.2rem;
        margin-top: 25px;
        margin-bottom: 15px;
        margin-left: 5px;
        color: #52aaff;
        font-weight: 700;
        text-shadow: 0 0 6px #1b5f99;
        letter-spacing: 1px;
    }

    .carrossel-wrapper {
        position: relative;
        width: 100%;
        overflow: hidden;
        padding: 10px 0 25px 0;
    }

    .carrossel {
        display: flex;
        gap: 22px;
        transition: transform 0.3s ease-in-out;
    }

    /* CARD */
    .filme-card {
        flex: 0 0 calc((100% - 66px) / 4); /* 4 colunas */
        height: 380px;
        position: relative;
        border-radius: 14px;
        overflow: hidden;
        cursor: pointer;
        transition: 0.3s;
        background: #0a0d13;
        border: 1px solid #0f1623;
        box-shadow: 0 0 12px rgba(0, 102, 255, 0.15);
    }

    .filme-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 18px rgba(0, 102, 255, 0.35);
    }

    .filme-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(45%);
        transition: 0.3s ease;
    }

    .filme-card:hover img {
        filter: brightness(65%);
        transform: scale(1.03);
    }

    /* INFO DO FILME */
    .filme-info {
        position: absolute;
        bottom: 65px;
        left: 10px;
        right: 10px;
        text-shadow: 0px 0px 8px black;
    }

    .filme-titulo {
        font-size: 1.25rem;
        font-weight: 800;
        color: #fff;
    }

    .filme-ano, .filme-categoria, .filme-preco {
        font-size: 0.95rem;
        color: #cfd9e6;
        font-weight: 500;
    }

    .filme-preco {
        color: #4da3ff;
        font-weight: 700;
    }

    /* ÍCONES */
    .card-icons {
        position: absolute;
        bottom: 12px;
        left: 10px;
        right: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-icons button {
        background: rgba(0, 0, 0, 0.4);
        border: none;
        font-size: 1.6rem;
        cursor: pointer;
        border-radius: 50%;
        width: 44px;
        height: 44px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(6px);
        transition: 0.25s;
    }

    .card-icons button:hover {
        background: rgba(77,161,255,0.6);
        transform: scale(1.18);
    }

    /* SETAS */
    .seta {
        position: absolute;
        top: 45%;
        transform: translateY(-50%);
        font-size: 2.6rem;
        cursor: pointer;
        color: #4da3ff;
        z-index: 10;
        user-select: none;
        transition: 0.2s;
        padding: 8px;
    }

    .seta:hover {
        color: #7bbcff;
        transform: scale(1.15);
    }

    .seta-esquerda { left: 5px; }
    .seta-direita { right: 5px; }
</style>

<div class="container">
    <h2 class="titulo-secao">Nossos Filmes</h2>

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

                        {{-- Favorito --}}
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

                        {{-- Carrinho (CORRIGIDO: 'carrinho.adicionar' => 'carrinho.add') --}}
                        <form action="{{ route('carrinho.add', $filme->id) }}" method="POST">
                            @csrf
                            <button type="submit">🛒</button>
                        </form>

                    </div>

                </div>
            @endforeach
        </div>
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

    const cardWidth = carrossel.children[0].offsetWidth + 22;
    carrossel.style.transform = `translateX(-${indice * cardWidth}px)`;
}
</script>

</x-app-layout>