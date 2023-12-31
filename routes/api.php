<?php

use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/pessoas')->group(function () {
    Route::get('/{uuid}', [PersonController::class, 'show']);
    Route::get('/', [PersonController::class, 'search']);
    Route::post('/', [PersonController::class, 'store']);
});

Route::get('/contagem-pessoas', [PersonController::class, 'count']);
