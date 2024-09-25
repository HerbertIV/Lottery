<?php

namespace App\Listeners;

use App\Events\SmsSendEvent;
use App\Services\Contracts\MembersServiceContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SmsSendListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly MembersServiceContract $membersService
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(SmsSendEvent $event): void
    {
        $this->membersService->sendDrawnMember($event->getMember());
    }
}
