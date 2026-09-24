<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\AuthController;



// Suas rotas continuam aqui embaixo...
//  TODO proteger por jwt

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:api')->group(function () {
    // rotas protegidas
});

// Listar filmes
Route::get('/filmes', [FilmeController::class, 'index']);

// Salvar um novo filme
Route::post('/filmes', [FilmeController::class, 'store']);

Route::get('/filmes/{hashid}', [FilmeController::class, 'show']);

Route::put('/filmes/{hashid}', [FilmeController::class, 'update']);

Route::delete('/filmes/{hashid}', [FilmeController::class, 'destroy']);

Route::post('/filmes/filtro', [FilmeController::class, 'filtrar']);

Route::post('cadastrar', [AuthController::class, 'cadastro']);

Route::post('login', [AuthController::class, 'login']);