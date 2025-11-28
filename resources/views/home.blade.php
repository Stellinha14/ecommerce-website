@extends('layouts.app')

@section('content')
<div class="hero-container">
    <h1 class="hero-title">Filmes, séries e muito mais, sem limites</h1>
    <p class="hero-subtitle"><b>A partir de <span>R$ 20,90</span>. Cancele quando quiser.</b></p>
    <div class="hero-row">
        <p class="hero-email-text">Quer assistir? Informe seu email para criar ou reiniciar sua assinatura.</p>
        <div class="hero-row">
            <input type="email" id="emailInput" placeholder="Email" class="hero-email">
            <button id="goButton" class="btn-primary hero-btn">Vamos lá <i class="fa-solid fa-arrow-right" style="color: #ffffff;"></i></button>
        </div>
    </div>
</div>
@endsection
