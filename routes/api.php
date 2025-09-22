<?php

use App\Http\Controllers\Api\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('contacts/search', [ContactController::class, 'search']);

Route::apiResource('contacts', ContactController::class);
