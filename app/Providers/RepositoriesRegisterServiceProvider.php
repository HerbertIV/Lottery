<?php

namespace App\Providers;

use App\Repositories\Contracts\MemberRepositoriesContract;
use App\Repositories\MemberRepositories;
use Illuminate\Support\ServiceProvider;

class RepositoriesRegisterServiceProvider extends ServiceProvider
{
    public $singletons = [
        MemberRepositoriesContract::class => MemberRepositories::class,
    ];
}
