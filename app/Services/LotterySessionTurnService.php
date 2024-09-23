<?php

namespace App\Services;

use App\Http\Requests\StoreTurnRequest;
use App\Models\LotterySession;
use App\Models\LotterySessionTurn;
use App\Models\Member;
use App\Services\Contracts\LotterySessionTurnServiceContract;

class LotterySessionTurnService implements LotterySessionTurnServiceContract
{
    public function store(LotterySession $lotterySession, StoreTurnRequest $request): LotterySessionTurn
    {
        return $lotterySession->lotterySessionTurns()->create([
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
        ]);
    }

    public function getEligibleMembersForDrawer(
        LotterySession $lotterySession,
        Member $member
    ) {
        $members = Member::query()
            ->selectRaw('lottery_session_turn_members.drawn_member_uuid, COUNT(*) as count')
            ->join('lottery_session_turn_members', 'members.uuid', '=', 'lottery_session_turn_members.member_uuid')
            ->join('lottery_session_turns', 'lottery_session_turn_members.lottery_session_turn_id', '=', 'lottery_session_turns.id')
            ->where('lottery_session_turns.lottery_session_id', '=', $lotterySession->getKey())
            ->where('members.uuid', '=', $member->getKey())
            ->groupBy('lottery_session_turn_members.drawn_member_uuid')
            ->orderBy('count', 'asc')
            ->get();

        return $members;
    }
}
