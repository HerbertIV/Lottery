<?php

use App\Http\Controllers\LotteryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LotteryController::class, 'render'])->name('session.render');
Route::post('/', [LotteryController::class, 'setSession'])->name('session.set');
Route::get('/{session}', [LotteryController::class, 'show'])->name('session.show');
Route::post('/{session}', [LotteryController::class, 'store'])->name('session.store');
