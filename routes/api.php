<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/products', function (Request $request) {
    return \App\Models\Product::all();
})->middleware('auth:sanctum');
