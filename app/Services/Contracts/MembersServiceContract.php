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
    public function getMemberByName(string $memberName): ?Member;
    public function getMemberNotDrawn(LotterySession $lotterySession, ?Member $withoutMe = null): Collection;
    public function draw(Member $member, string $sessionName): ?Member;
    public function sendDrawnMember(Member $member, string $sessionName): bool;
}
