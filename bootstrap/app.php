<?php

use App\Http\Middleware\Authenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'redirect.if.authenticated' => Authenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function (Throwable $throwable) {
            $data = [
                'method' => request()->getMethod(),
                'message' => $throwable->getMessage(),
                'user' => auth()->id(),
                'data' => request()->all(),
            ];
            if ($throwable instanceof ValidationException) {
                $data['errors'] = $throwable->errors();
            }
            Log::error(json_encode($data, JSON_PRETTY_PRINT));
        });
    })
    ->create();
