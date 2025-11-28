<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorito;
use App\Models\Filme;

class FavoritoController extends Controller
{
    public function toggle($id)
    {
        $user = Auth::user();

        $favorito = Favorito::where('user_id', $user->id)
                            ->where('filme_id', $id)
                            ->first();

        if ($favorito) {
            $favorito->delete();
        } else {
            Favorito::create([
                'user_id' => $user->id,
                'filme_id' => $id,
            ]);
        }

        return back();
    }

    public function index()
    {
        $user = Auth::user();

        // pega os IDs dos filmes favoritados
        $favoritos = Filme::whereIn('id', 
            Favorito::where('user_id', $user->id)->pluck('filme_id')
        )->get();

        return view('favoritos.index', compact('favoritos'));
    }
}
