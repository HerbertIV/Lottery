<?php

namespace App\Services;

use App\Models\LotterySession;
use App\Models\Member;
use App\Services\Contracts\LotterySessionServiceContract;
use App\Services\Contracts\LotterySessionTurnServiceContract;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class LotterySessionService implements LotterySessionServiceContract
{
    public function __construct(
        private readonly LotterySessionTurnServiceContract  $lotterySessionTurnService
    ) {
    }

    public function getSessionByName(
        string $sessionName,
        array $with = []
    ): LotterySession {
        $lotterySession = LotterySession::whereSessionName($sessionName)
            ->with($with)
            ->first();

        if (!$lotterySession) {
            throw new Exception('Ta sesja nie istnieje.');
        }

        return $lotterySession;
    }

    public function generate(): LotterySession
    {
        return LotterySession::create([
            'session_name' => Str::random(5)
        ]);
    }

    public function getCanDrawMembersFromActiveTurnInLotterySession(
        LotterySession $lotterySession
    ): Collection {
        $activeTurn = $lotterySession->activeLotterySessionTurns->first();

        return $lotterySession
            ->members
            ->filter(
                fn (Member $member) => !in_array(
                    $member->uuid,
                    $activeTurn ? $activeTurn->lotterySessionTurnMembers->pluck('member_uuid')->toArray() : [],
                    true
                )
            );
    }

    public function getCanNotDrawMembersFromActiveTurnInLotterySession(LotterySession $lotterySession): Collection
    {
        $activeTurn = $lotterySession->activeLotterySessionTurns->first();

        return $lotterySession
            ->members
            ->filter(
                fn (Member $member) => in_array(
                    $member->uuid,
                    $activeTurn ? $activeTurn->lotterySessionTurnMembers->pluck('member_uuid')->toArray() : [],
                    true
                )
            );
    }

    public function getNotDrawnMembersFromActiveTurnInLotterySession(
        LotterySession $lotterySession,
        ?Member $memberDrawing = null
    ) {
        $activeTurn = $lotterySession->activeLotterySessionTurns->first();
        if (!$memberDrawing) {
            $lotterySessionTurnMembers = $activeTurn->lotterySessionTurnMembers;
        } else {
            $eligibleMembers = $this->lotterySessionTurnService->getEligibleMembersForDrawer(
                $lotterySession,
                $memberDrawing
            );
            $lotterySessionTurnMembers = $activeTurn->lotterySessionTurnMembers
                ->merge($eligibleMembers)
                ->push(collect(['drawn_member_uuid' => $memberDrawing->getKey()]));
        }

        return $lotterySession->members()->whereNotIn(
            'uuid',
            $lotterySessionTurnMembers->pluck('drawn_member_uuid')->toArray()
        )->get();
    }
}
