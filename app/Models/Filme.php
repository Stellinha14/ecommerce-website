<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filme extends Model
{
     protected $fillable = [
        'titulo',
        'capa',
        'descricao',
        'categoria',
        'ano',
        'preco',
    ];

    public function favoritos()
{
    return $this->hasMany(\App\Models\Favorito::class);
}

}
