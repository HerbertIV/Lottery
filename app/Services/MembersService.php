<?php

namespace App\Services;

use App\Http\Requests\MemberStoreRequest;
use App\Models\LotterySession;
use App\Models\Member;
use App\Services\Contracts\MembersServiceContract;

class MembersService implements MembersServiceContract
{

    public function store(LotterySession $lotterySession, MemberStoreRequest $request): bool
    {
        return $lotterySession->members()->save(new Member(['name' => $request->name]));
    }
}
