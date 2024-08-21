<?php

namespace App\Facades;

use App\Services\Contracts\SmsServiceContract;
use Illuminate\Support\Facades\Facade;

class Sms extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SmsServiceContract::class;
    }
}
