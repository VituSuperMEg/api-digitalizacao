<?php

use App\Http\Controllers\OrgaosController;
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
Route::post('/orgaos', [OrgaosController::class, 'store']);
Route::post('/orgaos/update', [OrgaosController::class, 'update']);
Route::delete('/orgaos/{id}', [OrgaosController::class, 'delete']);


