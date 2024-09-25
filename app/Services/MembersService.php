<?php

namespace App\Services;

use App\Facades\Sms;
use App\Http\Requests\MemberStoreRequest;
use App\Models\LotterySession;
use App\Models\Member;
use App\Services\Contracts\LotterySessionServiceContract;
use App\Services\Contracts\LotterySessionTurnMemberServiceContract;
use App\Services\Contracts\MembersServiceContract;
use Illuminate\Support\Facades\Log;

class MembersService implements MembersServiceContract
{
    public function __construct(
        private readonly LotterySessionServiceContract $lotterySessionService,
        private readonly LotterySessionTurnMemberServiceContract $lotterySessionTurnMemberService
    ) {
    }

    /**
     * @param  LotterySession  $lotterySession
     * @param  MemberStoreRequest  $request
     * @return Member
     */
    public function store(LotterySession $lotterySession, MemberStoreRequest $request): Member
    {
        return $lotterySession->members()->save(new Member([
            'name' => mb_strtolower($request->name),
            'phone' => $request->phone
        ]));
    }

    public function destroy(Member $member): bool
    {
        try {
            return $member->delete();
        } catch (\Exception $exception) {
            Log::error('Error in member destroy: ' . $exception->getMessage());

            return false;
        }
    }

    public function memberInSession(string $memberName, string $sessionName): ?Member
    {
        $lotterySession = $this->lotterySessionService->getSessionByName($sessionName);

        return $lotterySession?->members()->whereName(mb_strtolower($memberName))->first();
    }

    public function getMemberByNameFromSession(
        string $memberName,
        string $sessionName
    ): ?Member {
        return Member::joinRelationship('lotterySession')
            ->where('members.name', '=', mb_strtolower($memberName))
            ->where('lottery_sessions.session_name', '=', $sessionName)
            ->first();
    }

    public function draw(Member $member, ?LotterySession $lotterySession = null): ?Member
    {
        if (!$member->canDraw()) {
            throw new \Exception('Ten uczestnik już losował');
        }

        $lotterySession = $lotterySession ?: $member->lotterySession;
        $memberDrawn = $this->lotterySessionService
            ->getNotDrawnMembersFromActiveTurnInLotterySession(
                $lotterySession,
                $member
            )->random(1)
            ->first();
        $this->lotterySessionTurnMemberService->store($lotterySession, $member, $memberDrawn);

        return $memberDrawn;
    }

    public function getMemberDrawn(Member $member): ?Member
    {
        $lotterySession = $member->lotterySession()->with('activeLotterySessionTurns')->first();
        $activeTurn = $lotterySession?->activeLotterySessionTurns;

        return $activeTurn
            ?->lotterySessionTurnMembers()
            ->where('member_uuid', '=', $member->getKey())
            ->first()
            ?->drawnMember;
    }

    public function sendDrawnMember(Member $member): bool
    {
        $memberDrawn = $this->getMemberDrawn($member);
        if (!$memberDrawn) {
            $memberDrawn = $this->draw($member);
        }

        return Sms::make()
            ->setTo($member->phone)
            ->setFrom('TEST')
            ->setMessage('Wylosowales ' . $memberDrawn->name)
            ->send();
    }
}
