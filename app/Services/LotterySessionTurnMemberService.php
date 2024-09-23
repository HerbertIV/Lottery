<?php

namespace App\Services;

use App\Models\LotterySession;
use App\Models\LotterySessionTurnMember;
use App\Models\Member;
use App\Services\Contracts\LotterySessionTurnMemberServiceContract;

class LotterySessionTurnMemberService implements LotterySessionTurnMemberServiceContract
{
    public function store(
        LotterySession $lotterySession,
        Member $member,
        Member $memberDrawn
    ): LotterySessionTurnMember {

        return $lotterySession->activeLotterySessionTurns->first()->lotterySessionTurnMembers()->create([
            'member_uuid' => $member->getKey(),
            'drawn_member_uuid' => $memberDrawn->getKey(),
        ]);
    }
}
