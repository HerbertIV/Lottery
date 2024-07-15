<?php

namespace App\Services\Contracts;

use App\Http\Requests\MemberStoreRequest;
use App\Models\LotterySession;

interface MembersServiceContract
{
    public function store(LotterySession $lotterySession, MemberStoreRequest $request): bool;
}
