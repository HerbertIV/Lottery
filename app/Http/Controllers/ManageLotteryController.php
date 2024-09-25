<?php

namespace App\Http\Controllers;

use App\Events\SmsSendEvent;
use App\Http\Requests\CreateSessionRequest;
use App\Http\Requests\DestroyMemberRequest;
use App\Http\Requests\MemberStoreRequest;
use App\Http\Requests\SendDrawnMemberRequest;
use App\Http\Requests\StoreSessionRequest;
use App\Http\Requests\StoreTurnRequest;
use App\Models\LotterySession;
use App\Models\Member;
use App\Services\Contracts\LotterySessionServiceContract;
use App\Services\Contracts\LotterySessionTurnServiceContract;
use App\Services\Contracts\MembersServiceContract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ManageLotteryController extends Controller
{
    public function __construct(
        private readonly MembersServiceContract $membersService,
        private readonly LotterySessionServiceContract $lotterySessionService,
        private readonly LotterySessionTurnServiceContract $lotterySessionTurnService
    ) {
    }

    public function store(StoreSessionRequest $request): RedirectResponse|Redirector
    {
        $session = $this->lotterySessionService->generate();
        return redirect(
            route('lottery-session.show', [
                'lotterySessionName' => $session->session_name
            ])
        );
    }

    public function storeTurn(
        LotterySession $lotterySession,
        StoreTurnRequest $request
    ): RedirectResponse|Redirector {
        $this->lotterySessionTurnService->store($lotterySession, $request);

        return redirect(
            route('lottery-session.show', [
                'lotterySessionName' => $lotterySession->session_name
            ])
        );
    }

    public function create(CreateSessionRequest $request): View
    {
        return view('create');
    }

    public function storeMember(MemberStoreRequest $request, LotterySession $lotterySession): View
    {
        $this->membersService->store($lotterySession, $request);
        $lotterySession->refresh();

        return view('session', [
            'members' => $lotterySession->members,
            'activeSessionTurn' => $lotterySession->activeLotterySessionTurns()->first(),
            'membersCanDraw' => $this->lotterySessionService->getCanDrawMembersFromActiveTurnInLotterySession($lotterySession),
            'membersCanNotDraw' => $this->lotterySessionService->getCanNotDrawMembersFromActiveTurnInLotterySession($lotterySession),
            'lotterySessionName' => $lotterySession->session_name
        ]);
    }

    public function destroyMember(
        DestroyMemberRequest $request,
        LotterySession $lotterySession,
        Member $member
    ): RedirectResponse|Redirector {
        $this->membersService->destroy($member);

        return redirect(
            route('lottery-session.show', [$lotterySession])
        );
    }

    public function sendDrawnMember(
        LotterySession $lotterySession,
        Member $member
    ): RedirectResponse|Redirector {
        event(new SmsSendEvent($member));

        return redirect(route('lottery-session.show', [$lotterySession]));
    }
}
