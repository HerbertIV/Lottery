<?php

namespace App\Services\Contracts;

use App\Http\Requests\MemberStoreRequest;
use App\Models\LotterySession;
use App\Models\Member;

interface MembersServiceContract
{
    public function store(LotterySession $lotterySession, MemberStoreRequest $request): Member;
    public function destroy(Member $member): bool;
    public function memberInSession(string $memberName, string $sessionName): ?Member;
    public function getMemberByName(string $memberName): ?Member;
}
