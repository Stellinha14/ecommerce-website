<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filme;


class DashboardController extends Controller
{
    public function index()
    {
        $filmes = Filme::all(); // pega todos os filmes

        return view('dashboard', compact('filmes'));
    }
}
