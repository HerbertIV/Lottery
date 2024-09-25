<?php

namespace App\Services\Contracts;

use App\Models\LotterySession;
use App\Models\Member;
use Illuminate\Support\Collection;

interface LotterySessionServiceContract
{
    public function getSessionByName(string $sessionName, array $with = []): LotterySession;
    public function generate(): LotterySession;
    public function getCanDrawMembersFromActiveTurnInLotterySession(LotterySession $lotterySession): Collection;
    public function getCanNotDrawMembersFromActiveTurnInLotterySession(LotterySession $lotterySession): Collection;
    public function getNotDrawnMembersFromActiveTurnInLotterySession(LotterySession $lotterySession, ?Member $memberDrawing = null);
}
