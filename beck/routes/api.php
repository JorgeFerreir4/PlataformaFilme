<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user()->nome;
})->middleware('auth:api');

Route::get('/filmes', [FilmeController::class, 'index']);

Route::get('/filmes/{hashid}', [FilmeController::class, 'show']);

Route::post('/filmes/filtro', [FilmeController::class, 'filtrar']);

Route::post('cadastrar', [AuthController::class, 'cadastro']);

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::put('/filmes/{hashid}', [FilmeController::class, 'update']);

    Route::delete('/filmes/{hashid}', [FilmeController::class, 'destroy']);

    Route::post('/filmes', [FilmeController::class, 'store']);

    Route::post('/logout', [AuthController::class, 'logout']);
});