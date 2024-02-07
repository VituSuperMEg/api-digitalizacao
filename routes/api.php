<?php

use App\Http\Controllers\CaixasController;
use App\Http\Controllers\CredoresController;
use App\Http\Controllers\EstanteController;
use App\Http\Controllers\OrgaosController;
use App\Http\Controllers\SalasController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\TiposDocumentosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Credores
Route::get('/credores', [CredoresController::class, 'index']);
Route::get('/credores/{id}', [CredoresController::class, 'find']);
Route::post('/credores', [CredoresController::class, 'store']);
Route::post('/credores/update', [CredoresController::class, 'update']);
Route::delete('/credores/{id}', [CredoresController::class, 'delete']);


// Orgoas
Route::get('/orgaos', [OrgaosController::class, 'index']);
Route::get('/orgaos/{id}', [OrgaosController::class, 'find']);
Route::post('/orgaos', [OrgaosController::class, 'store']);
Route::post('/orgaos/update', [OrgaosController::class, 'update']);
Route::delete('/orgaos/{id}', [OrgaosController::class, 'delete']);

// Setor
Route::get('/setor', [SetorController::class, 'index']);
Route::get('/setor/{id}', [SetorController::class, 'find']);
Route::post('/setor', [SetorController::class, 'store']);
Route::post('/setor/update', [SetorController::class, 'update']);
Route::delete('/setor/{id}', [SetorController::class, 'delete']);

// Salas
Route::get('/salas', [SalasController::class, 'index']);
Route::get('/salas/{id}', [SalasController::class, 'find']);
Route::post('/salas', [SalasController::class, 'store']);
Route::post('/salas/update', [SalasController::class, 'update']);
Route::delete('/salas/{id}', [SalasController::class, 'delete']);

// Caixas
Route::get('/caixas', [CaixasController::class, 'index']);
Route::get('/caixas/{id}', [CaixasController::class, 'find']);
Route::post('/caixas', [CaixasController::class, 'store']);
Route::post('/caixas/update', [CaixasController::class, 'update']);
Route::delete('/caixas/{id}', [CaixasController::class, 'delete']);

// Tipos do documentos
Route::get('/tipos-documentos', [TiposDocumentosController::class, 'index']);
Route::post('/tipos-documentos', [TiposDocumentosController::class, 'store']);


// Estantes
Route::get('/estantes', [EstanteController::class, 'index']);
Route::get('/estantes/{id}', [EstanteController::class, 'find']);
Route::post('/estantes', [EstanteController::class, 'store']);
Route::post('/estantes/update', [EstanteController::class, 'update']);
Route::delete('/caixas/{id}', [CaixasController::class, 'delete']);
