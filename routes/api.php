<?php

use App\Http\Controllers\EstanteController;
use App\Http\Controllers\OrgaosController;
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

// Tipos do documentos
Route::get('/tipos-documentos', [TiposDocumentosController::class, 'index']);
Route::post('/tipos-documentos', [TiposDocumentosController::class, 'store']);


// Estantes
Route::get('/estantes', [EstanteController::class, 'index']);
Route::post('/estantes', [EstanteController::class, 'store']);
Route::post('/estantes/{id}', [EstanteController::class, 'update']);
