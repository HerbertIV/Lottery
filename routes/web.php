<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/{session}', [\App\Http\Controllers\LotteryController::class, 'show']);
Route::post('/{session}', [\App\Http\Controllers\LotteryController::class, 'store']);
