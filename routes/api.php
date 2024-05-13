<?php

use App\Http\Controllers\API\V1\AuthorController;
use App\Http\Controllers\API\V1\BookController;
use App\Http\Controllers\API\V1\LoanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/authors', AuthorController::class);
Route::apiResource('/books', BookController::class);
Route::apiResource('/loans', LoanController::class);
