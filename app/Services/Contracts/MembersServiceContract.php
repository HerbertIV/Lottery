<?php

namespace App\Services\Contracts;

use App\Http\Requests\MemberStoreRequest;
use App\Models\LotterySession;
use App\Models\Member;
use Illuminate\Support\Collection;

interface MembersServiceContract
{
    public function store(LotterySession $lotterySession, MemberStoreRequest $request): Member;
    public function destroy(Member $member): bool;
    public function memberInSession(string $memberName, string $sessionName): ?Member;
    public function getMemberByNameFromSession(string $memberName, string $sessionName): ?Member;
    public function draw(Member $member, ?LotterySession $lotterySession = null): ?Member;
    public function sendDrawnMember(Member $member): bool;
}
