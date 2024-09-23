<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\Contracts\AuthServiceContract;
use Illuminate\Contracts\View\View;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthServiceContract $authService
    ) {
    }

    public function render(): View
    {
        return view('auth');
    }

    public function login(LoginRequest $request)
    {
        if ($this->authService->login(
            $request->only(['email', 'password'])
        )) {
            return redirect()->intended(route('lottery-session.render'));
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }
}
