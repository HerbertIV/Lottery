<?php

namespace App\Repositories;

use App\Models\LotterySession;
use App\Repositories\Contracts\MemberRepositoriesContract;

class MemberRepositories implements MemberRepositoriesContract
{
    public function getMembersForSession(LotterySession $lotterySession)
    {
        $activeTurn = $lotterySession->activeLotterySessionTurns->first();

        if (!$activeTurn) {
            $members = $lotterySession->members;
        } else {
            $members = $lotterySession
                ->members()
                ->selectRaw('members.*, IF(COUNT(lottery_session_turn_members.member_uuid) = 0, TRUE, FALSE) AS can_draw')
                ->leftJoinRelationship(
                    'lotterySessionTurnsMember',
                    fn ($join) => $join->where('lottery_session_turn_members.lottery_session_turn_id', '=', $activeTurn->getKey())
                )
                ->groupBy(
                    'members.uuid',
                    'members.lottery_session_id',
                    'members.name',
                    'members.phone',
                    'members.created_at',
                    'members.updated_at',
                    'members.email'
                )
                ->get();
        }

        return $members;
    }
}
