<?php

namespace App\Services\Contracts;

use App\Models\LotterySession;

interface LotterySessionServiceContract
{
    public function getSessionByName(string $sessionName): LotterySession;
    public function generate(): LotterySession;
}
