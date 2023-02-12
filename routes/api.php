<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;

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

Route::prefix('book')->group(function() {
    Route::match(['get', 'post'], '/', [BookController::class, 'index']);
    Route::get('/book/{id}', [BookController::class, 'show']);
    Route::post('/store', [BookController::class, 'store']);
    Route::post('/update/{id}', [BookController::class, 'update']);
    Route::get('/destroy/{id}', [BookController::class, 'destroy']);
    Route::get('/status/{id}', [BookController::class, 'changeStatus']);
});

Route::prefix('author')->group(function() {
    Route::match(['get', 'post'], '/', [AuthorController::class, 'index']);
    Route::get('/author/{id}', [AuthorController::class, 'show']);
    Route::post('/update/{id}', [AuthorController::class, 'update']);
    Route::get('/destroy/{id}', [AuthorController::class, 'destroy']);
    Route::post('/store', [AuthorController::class, 'store']);
});
