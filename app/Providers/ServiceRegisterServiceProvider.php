<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\Contracts\AuthServiceContract;
use App\Services\Contracts\LotterySessionServiceContract;
use App\Services\Contracts\LotterySessionTurnMemberServiceContract;
use App\Services\Contracts\LotterySessionTurnServiceContract;
use App\Services\Contracts\MembersServiceContract;
use App\Services\Contracts\SmsServiceContract;
use App\Services\LotterySessionService;
use App\Services\LotterySessionTurnMemberService;
use App\Services\LotterySessionTurnService;
use App\Services\MembersService;
use App\Services\SmsService;
use Illuminate\Support\ServiceProvider;

class ServiceRegisterServiceProvider extends ServiceProvider
{
    public $singletons = [
        MembersServiceContract::class => MembersService::class,
        LotterySessionServiceContract::class => LotterySessionService::class,
        SmsServiceContract::class => SmsService::class,
        AuthServiceContract::class => AuthService::class,
        LotterySessionTurnServiceContract::class => LotterySessionTurnService::class,
        LotterySessionTurnMemberServiceContract::class => LotterySessionTurnMemberService::class,
    ];
}
