<?php

namespace App\Services;

use App\Facades\Sms;
use App\Http\Requests\MemberStoreRequest;
use App\Models\LotterySession;
use App\Models\Member;
use App\Services\Contracts\LotterySessionServiceContract;
use App\Services\Contracts\LotterySessionTurnMemberServiceContract;
use App\Services\Contracts\MembersServiceContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class MembersService implements MembersServiceContract
{
    public function __construct(
        private readonly LotterySessionServiceContract $lotterySessionService,
        private readonly LotterySessionTurnMemberServiceContract $lotterySessionTurnMemberService
    ) {
    }

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

    public function getMemberByName(string $memberName): ?Member
    {
        return Member::whereName(mb_strtolower($memberName))->first();
    }

    public function getMemberNotDrawn(LotterySession $lotterySession, ?Member $withoutMe = null): Collection
    {
        return $lotterySession
            ->membersNotDrawn()
            ->when($withoutMe, fn (Builder $builder) => $builder->where('uuid', '<>', $withoutMe->getKey()))
            ->get();
    }

    public function draw(Member $member, string $sessionName): ?Member
    {
        if (!$member->canDraw()) {
            throw new \Exception('Ten uczestnik już losował');
        }
        $lotterySession = $this->lotterySessionService->getSessionByName($sessionName);
        $memberDrawn = $this->lotterySessionService->getNotDrawnMembersFromActiveTurnInLotterySession(
            $lotterySession,
            $member
        )->random(1)->first();

        $this->lotterySessionTurnMemberService->store($lotterySession, $member, $memberDrawn);

        return $memberDrawn;
    }

    public function getMemberDrawn(Member $member, string $sessionName): ?Member
    {
        $lotterySession = $this->lotterySessionService->getSessionByName($sessionName);
        $activeTurn = $lotterySession->activeLotterySessionTurns()->first();

        return $activeTurn
            ->lotterySessionTurnMembers()
            ->where('member_uuid', '=', $member->getKey())
            ->first()
            ?->drawnMember;
    }

    public function sendDrawnMember(Member $member, string $sessionName): bool
    {
        $memberDrawn = $this->getMemberDrawn($member, $sessionName);
        if (!$memberDrawn) {
            $memberDrawn = $this->draw($member, $sessionName);
        }

        return Sms::make()
            ->setTo($member->phone)
            ->setFrom('TEST')
            ->setMessage('Wylosowales ' . $memberDrawn->name)
            ->send();
    }
}
