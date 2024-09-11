<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LotteryController;
use App\Http\Controllers\ManageLotteryController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/login', 'middleware' => ['redirect.if.authenticated']], function () {
    Route::get('/', [AuthController::class, 'render'])->name('login');
    Route::post('/', [AuthController::class, 'login'])->name('auth.login');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/create', [ManageLotteryController::class, 'create'])->name('session.create');
    Route::post('/create', [ManageLotteryController::class, 'store'])->name('session.store');
    Route::group(['prefix' => '/{session}'], function () {
        Route::post('/', [ManageLotteryController::class, 'storeMember'])->name('session.member.store');
        Route::delete('/{member}', [ManageLotteryController::class, 'destroyMember'])->name('session.member.destroy');
        Route::get('/{member}/send', [ManageLotteryController::class, 'sendDrawnMember'])->name('session.member.send-drawn-member');
    });
});

Route::get('/', [LotteryController::class, 'render'])->name('session.render');
Route::post('/', [LotteryController::class, 'setSession'])->name('session.set');
Route::group(['prefix' => '/{session}'], function () {
    Route::get('/', [LotteryController::class, 'show'])->name('session.show');
    Route::get('/{member}', [LotteryController::class, 'lottery'])->name('session.lottery');
    Route::post('/{member}', [LotteryController::class, 'drawMember'])->name('session.draw_member');
});

