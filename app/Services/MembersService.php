<?php

namespace App\Services;

use App\Http\Requests\MemberStoreRequest;
use App\Models\LotterySession;
use App\Models\Member;
use App\Services\Contracts\MembersServiceContract;

class MembersService implements MembersServiceContract
{

    public function store(LotterySession $lotterySession, MemberStoreRequest $request): Member
    {
        return $lotterySession->members()->save(new Member([
            'name' => $request->name,
            'phone' => $request->phone
        ]));
    }

    public function destroy(Member $member): bool
    {
        try {
            return $member->delete();
        } catch (\Exception $exception) {
            return false;
        }
    }
}
