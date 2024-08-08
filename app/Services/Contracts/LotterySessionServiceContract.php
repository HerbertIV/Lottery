<?php

namespace App\Services\Contracts;

use App\Http\Requests\MemberStoreRequest;
use App\Models\LotterySession;
use App\Models\Member;

interface LotterySessionServiceContract
{
    public function getSessionByName(string $sessionName): ?LotterySession;
    public function generate(): LotterySession;
}
