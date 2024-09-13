<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function (Request $request) {
    dd([
        env('DB_CONNECTION'),
        env('DB_HOST'),
        env('DB_USERNAME'),
        env('DB_PASSWORD'),
    ]);
});
