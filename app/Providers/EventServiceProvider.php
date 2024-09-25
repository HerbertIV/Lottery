<?php

namespace App\Providers;

use App\Events\SmsSendEvent;
use App\Listeners\SmsSendListener;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SmsSendEvent::class => [
            SmsSendListener::class,
        ]
    ];
}
