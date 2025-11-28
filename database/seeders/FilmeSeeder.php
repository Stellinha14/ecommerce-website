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
            'capa' => 'fundo.png',
            'descricao' => 'Um mistério sombrio escondido na escuridão.',
            'categoria' => 'Aventura',
            'ano' => 2024,
        ]);

        Filme::create([
            'titulo' => 'Flores de Primavera',
            'capa' => 'fundo.png',
            'descricao' => 'Uma história leve e emocionante.',
            'categoria' => 'Drama',
            'ano' => 2023,
        ]);

        Filme::create([
            'titulo' => 'A Ressaca do Primeiro Tempo',
            'capa' => 'fundo.png',
            'descricao' => 'Comédia juvenil super divertida.',
            'categoria' => 'Comédia',
            'ano' => 2025,
        ]);
    }
}
