<?php

namespace App\Services\Contracts;

interface AuthServiceContract
{
    public function login(array $credentials): bool;
}
