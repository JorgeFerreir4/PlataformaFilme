<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmeController;

Route::get('/', function () {
    return view('welcome');
});


/* Listar filmes
Route::get('/filmes', [FilmeController::class, 'index']);

// Mostrar formulário de cadastro
Route::get('/filmes/criar', [FilmeController::class, 'create']);

// Salvar um novo filme
Route::post('/filmes', [FilmeController::class, 'store']);

// Mostrar formulário com os dados do filme para editar
Route::get('/filmes/{id}/editar', [FilmeController::class, 'edit']);

Route::get('/filmes/{id}', [FilmeController::class, 'show']);

Route::put('/filmes/{id}', [FilmeController::class, 'update']);

Route::delete('/filmes/{id}', [FilmeController::class, 'destroy']);*/ 

