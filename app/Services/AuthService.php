<?php

namespace App\Services;

use App\Exceptions\SmsSendException;
use App\Services\Contracts\AuthServiceContract;
use App\Services\Contracts\SmsServiceContract;
use App\Traits\FacadeHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\Translation\t;

class AuthService implements AuthServiceContract
{
    public function login(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }
}
