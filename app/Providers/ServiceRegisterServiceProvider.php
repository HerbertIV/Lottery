<?php

namespace App\Providers;

use App\Services\Contracts\LotterySessionServiceContract;
use App\Services\Contracts\MembersServiceContract;
use App\Services\LotterySessionService;
use App\Services\MembersService;
use Illuminate\Support\ServiceProvider;

class ServiceRegisterServiceProvider extends ServiceProvider
{
    public $singletons = [
        MembersServiceContract::class => MembersService::class,
        LotterySessionServiceContract::class => LotterySessionService::class,
    ];
}
