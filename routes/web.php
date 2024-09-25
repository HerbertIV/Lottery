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
    Route::get('/create', [ManageLotteryController::class, 'create'])->name('lottery-session.create');
    Route::post('/create', [ManageLotteryController::class, 'store'])->name('lottery-session.store');
    Route::group(['prefix' => '/{lotterySession:session_name}'], function () {
        Route::post('/', [ManageLotteryController::class, 'storeMember'])->name('lottery-session.member.store');
        Route::delete('/{member}', [ManageLotteryController::class, 'destroyMember'])->name('lottery-session.member.destroy');
        Route::get('/{member}/send', [ManageLotteryController::class, 'sendDrawnMember'])->name('lottery-session.member.send-drawn-member');


        Route::post('/store-turn', [ManageLotteryController::class, 'storeTurn'])->name('lottery-session.turn.store');
    });
});

Route::get('/', [LotteryController::class, 'render'])->name('lottery-session.render');
Route::post('/', [LotteryController::class, 'setSession'])->name('lottery-session.set');
Route::group(['prefix' => '/{lotterySession:session_name}'], function () {
    Route::get('/', [LotteryController::class, 'show'])->name('lottery-session.show');
    Route::get('/{member}', [LotteryController::class, 'lottery'])->name('lottery-session.lottery');
    Route::post('/{member}', [LotteryController::class, 'drawMember'])->name('lottery-session.draw_member');
});

