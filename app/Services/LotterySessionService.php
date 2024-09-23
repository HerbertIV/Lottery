<?php

namespace App\Services;

use App\Models\LotterySession;
use App\Models\Member;
use App\Services\Contracts\LotterySessionServiceContract;
use App\Services\Contracts\LotterySessionTurnServiceContract;
use Exception;
use Illuminate\Support\Str;

class LotterySessionService implements LotterySessionServiceContract
{
    public function __construct(
        private readonly LotterySessionTurnServiceContract  $lotterySessionTurnService
    ) {
    }

    public function getSessionByName(string $sessionName): LotterySession
    {
        $lotterySession = LotterySession::whereSessionName($sessionName)->first();
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

    public function getCanDrawMembersFromActiveTurnInLotterySession(LotterySession $lotterySession)
    {
        $activeTurn = $lotterySession->activeLotterySessionTurns->first();

        return $lotterySession->members()->whereNotIn(
            'uuid',
            $activeTurn->lotterySessionTurnMembers->pluck('member_uuid')->toArray()
        )->get();
    }

    public function getCanNotDrawMembersFromActiveTurnInLotterySession(LotterySession $lotterySession)
    {
        $activeTurn = $lotterySession->activeLotterySessionTurns->first();

        return $lotterySession->members()->whereIn(
            'uuid',
            $activeTurn->lotterySessionTurnMembers->pluck('member_uuid')->toArray()
        )->get();
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

    public function getDrawnMembersFromActiveTurnInLotterySession(
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

        return $lotterySession->members()->whereIn(
            'uuid',
            $lotterySessionTurnMembers->pluck('drawn_member_uuid')->toArray()
        )->get();
    }
}
