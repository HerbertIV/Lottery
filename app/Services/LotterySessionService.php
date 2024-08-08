<?php

namespace App\Services;

use App\Models\LotterySession;
use App\Services\Contracts\LotterySessionServiceContract;
use Illuminate\Support\Str;

class LotterySessionService implements LotterySessionServiceContract
{
    public function getSessionByName(string $sessionName): ?LotterySession
    {
        return LotterySession::whereSessionName($sessionName)->first();
    }

    public function generate(): LotterySession
    {
        return LotterySession::create([
            'session_name' => Str::random(5)
        ]);
    }
}
