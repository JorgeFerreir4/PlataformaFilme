<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filme;
use Illuminate\Support\Facades\Storage;

class FilmeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Busca todos os filmes no banco
        $filmes = Filme::select(['id', 'titulo', 'diretor', 'ano', 'genero', 'sinopse', 'capa'])->limit(5)->get();
        foreach($filmes as $filme){
            $filme->hashid = app('hashids')->encode($filme->id);
            unset($filme->id);
        }
    
        return response()->json($filmes, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação (conforme seu plano)
        $validated = $request->validate([
            'titulo' => 'required|string',
            'diretor' => 'required|string',
            'ano' => 'required|integer',
            'genero' => 'required|string',
            'sinopse' => 'nullable|string',
            'capa' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ]);
        if ($request->hasFile('capa')) {
            $caminho = $request->file('capa')->store('capas', 'public');
            $validated['capa'] = $caminho;
}
        $filmes = Filme::create($validated);

        // Retorna 201 Created com o objeto criado em JSON
        return response()->json(null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $filmes = Filme::findOrFail($id);
    
    return response()->json(['data' => $filmes], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $hashid)
    {
        $id = app('hashids')->decode($hashid);
        $filme = \App\Models\Filme::findOrFail($id[0]);
        $validated =  $request->validate([
            'titulo' => 'required|string',
            'diretor' => 'required|string',
            'ano' => 'required|integer',
            'genero' => 'required|string',
            'sinopse' => 'nullable|string',
            'capa' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ]);
        
        if ($validated['sinopse'] === 'null') {
        $validated['sinopse'] = null;
    }
        $filme->fill($validated);

        if ($request->hasFile('capa')) {
            $caminho = $request->file('capa')->store('capas', 'public');
            $filme->capa = $caminho;
        }

        $filme->save();
        return response()->json(null, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $hashid)
{
    $id = app('hashids')->decode($hashid);
    $filme = Filme::findOrFail($id[0]);

    // Se existir uma imagem
    if ($filme->capa) {

        // Apaga o arquivo da pasta storage/app/public
        Storage::disk('public')->delete($filme->capa);
    }

    // Apaga o registro do banco
    $filme->delete();

    return response()->json([
        'message' => 'Filme excluído com sucesso.'
    ]);
}

 public function filtrar(Request $request)
{
    
    $titulo = $request->input('titulo');
    $ano = $request->input('ano');
    $generos = $request->input('generos');
    $filmes = Filme::select(['id', 'titulo', 'diretor', 'ano', 'genero', 'sinopse', 'capa'])->where('titulo', 'LIKE','%'. $titulo .'%')
    ->when($ano, function ($query) use ($ano){
        $query->where('ano', $ano);
    })->when($generos, function ($query) use ($generos) {
        $query->where(function ($query) use ($generos) {
            
        foreach ($generos as $g) {
            $query->orWhere('genero', 'LIKE', '%' . $g . '%');
        }

        });
    })
    ->orderBy('ano', 'desc')->paginate(5);


    foreach($filmes as $filme){
            $filme->hashid = app('hashids')->encode($filme->id);
            unset($filme->id);
        }

    return response()->json($filmes, 200);

}


}   

