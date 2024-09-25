<?php

namespace App\Repositories\Contracts;

use App\Models\LotterySession;

interface MemberRepositoriesContract
{
    public function getMembersForSession(LotterySession $lotterySession);
}
