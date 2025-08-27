<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/category/add', [CategoryController::class, 'store']);
Route::get('/category/all', [CategoryController::class, 'index']);
Route::get('/category/show/{id}', [CategoryController::class, 'show']);