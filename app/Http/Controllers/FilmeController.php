<?php

namespace App\Http\Controllers;

use App\Models\Filme;
use Illuminate\Http\Request;

class FilmeController extends Controller
{
    public function index()
    {
        $filmes = Filme::all();
        return view('filmes.index', compact('filmes'));
    }

    public function create()
    {
        return view('filmes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'categoria' => 'nullable|string',
            'ano' => 'nullable|integer',
            'capa' => 'required|image|max:5120',
            'preco' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('capa')) {
            $validated['capa'] = $request->file('capa')->store('filmes', 'public');
        }

        Filme::create($validated);

        return redirect()->route('filmes.index')->with('success', 'Filme cadastrado com sucesso!');
    }

    public function show($id)
    {
        $filme = Filme::findOrFail($id);
        return view('filmes.show', compact('filme'));
    }

    public function edit($id)
    {
        $filme = Filme::findOrFail($id);
        return view('filmes.edit', compact('filme'));
    }

   public function update(Request $request, $id)
{
    $filme = Filme::findOrFail($id);

    // Validação
    $validated = $request->validate([
        'titulo' => 'required|string|max:255',
        'descricao' => 'nullable|string',
        'categoria' => 'nullable|string',
        'ano' => 'nullable|integer',
        'preco' => 'required|numeric|min:0',
        'capa' => 'nullable|image|max:5120', // agora opcional
    ]);

    // Atualiza a capa somente se o usuário enviou um novo arquivo
    if ($request->hasFile('capa')) {
        $validated['capa'] = $request->file('capa')->store('filmes', 'public');
    }

    $filme->update($validated);

    return redirect()->route('filmes.index')->with('success', 'Filme atualizado com sucesso!');
}


    public function destroy($id)
    {
        $filme = Filme::findOrFail($id);
        $filme->delete();

        return redirect()->route('filmes.index')->with('success', 'Filme removido com sucesso!');
    }
}
