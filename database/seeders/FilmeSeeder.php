<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Filme;

class FilmeSeeder extends Seeder
{
    public function run(): void
    {
        Filme::create([
            'titulo' => 'A Lenda da Caverna',
            'capa' => 'caverna_poster.png',
            'descricao' => 'Um mistério sombrio escondido na escuridão.',
            'categoria' => 'Aventura',
            'ano' => 2024,
            'preco' => 49.90, // adicionando preço
        ]);

        Filme::create([
            'titulo' => 'Flores de Primavera',
            'capa' => 'flores_poster.png',
            'descricao' => 'Uma história leve e emocionante.',
            'categoria' => 'Drama',
            'ano' => 2023,
            'preco' => 39.90,
        ]);

        Filme::create([
            'titulo' => 'A Ressaca do Primeiro Tempo',
            'capa' => 'ressaca_poster.png',
            'descricao' => 'Comédia juvenil super divertida.',
            'categoria' => 'Comédia',
            'ano' => 2025,
            'preco' => 29.90,
        ]);
    }
}
