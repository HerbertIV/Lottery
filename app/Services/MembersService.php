<?php

namespace App\Services;

use App\Facades\Sms;
use App\Http\Requests\MemberStoreRequest;
use App\Models\LotterySession;
use App\Models\Member;
use App\Services\Contracts\LotterySessionServiceContract;
use App\Services\Contracts\MembersServiceContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class MembersService implements MembersServiceContract
{
    public function __construct(
        private LotterySessionServiceContract $lotterySessionService
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
            ->when($withoutMe, fn (Builder $builder) => $builder->where('id', '<>', $withoutMe->getKey()))
            ->get();
    }

    public function draw(Member $member, string $sessionName): ?Member
    {
        if (!$member->can_draw) {
            throw new \Exception('Ten uczestnik już losował');
        }

        $lottery = $this->lotterySessionService->getSessionByName($sessionName);
        $memberDrawn = $this->getMemberNotDrawn($lottery, $member)->random();
        $this->markAsDrawn($member, $memberDrawn);

        return $memberDrawn;
    }

    public function markAsDrawn(Member $member, Member $memberDrawn): void
    {
        $member->update([
            'can_draw' => false,
            'drawn_member_id' => $memberDrawn->getKey()
        ]);
        $memberDrawn->update([
            'drawn' => true
        ]);
    }

    public function sendDrawnMember(Member $member, string $sessionName): bool
    {
        $memberDrawn = $member->memberDrawn;
        if (!$memberDrawn) {
            $memberDrawn = $this->draw($member, $sessionName);
        }

        return Sms::make()
            ->setTo($member->phone)
            ->setFrom('TEST')
            ->setMessage('Wylosowałeś: ' . $memberDrawn->name)
            ->send();
    }
}
