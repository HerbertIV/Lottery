<?php

namespace App\Http\Controllers;

use App\Http\Requests\DrawMemberRequest;
use App\Http\Requests\SessionSetRequest;
use App\Models\LotterySession;
use App\Models\Member;
use App\Repositories\Contracts\MemberRepositoriesContract;
use App\Services\Contracts\LotterySessionServiceContract;
use App\Services\Contracts\MembersServiceContract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LotteryController extends Controller
{
    public function __construct(
        private readonly MembersServiceContract $membersService,
        private readonly LotterySessionServiceContract $lotterySessionService,
        private readonly MemberRepositoriesContract $memberRepositories,
    ) {
    }

    public function render(): View
    {
        return view('home', [
            'lotterySessions' => LotterySession::all()
        ]);
    }

    public function setSession(SessionSetRequest $sessionSetRequest)
    {
        $member = $this->membersService->getMemberByNameFromSession(
            $sessionSetRequest->input('name'),
            $sessionSetRequest->input('session_name')
        );

        return redirect(
            route('lottery-session.lottery', [
                'lotterySession' => $sessionSetRequest->input('session_name'),
                'member' => $member
            ])
        );
    }

    public function show(LotterySession $lotterySession): View
    {
        return view('session', [
            'members' => $this->memberRepositories->getMembersForSession($lotterySession),
            'membersCanDraw' => $this->lotterySessionService->getCanDrawMembersFromActiveTurnInLotterySession($lotterySession),
            'membersCanNotDraw' => $this->lotterySessionService->getCanNotDrawMembersFromActiveTurnInLotterySession($lotterySession),
            'lotterySessionName' => $lotterySession->session_name,
            'activeSessionTurn' => $lotterySession->activeLotterySessionTurns->first()
        ]);
    }

    public function lottery(Request $request, LotterySession $lotterySession, Member $member): View
    {

        return view('lottery', [
            'activeLotterySessionTurn' => $lotterySession->activeLotterySessionTurns->first(),
            'lotterySessionName' => $lotterySession->session_name,
            'member' => $member
        ]);
    }

    public function drawMember(
        DrawMemberRequest $request,
        LotterySession $lotterySession,
        Member $member
    ): View {
        $memberDrawn = $this->membersService->draw($member);

        return view('lottery', [
            'lotterySessionName' => $lotterySession->session_name,
            'member' => $member,
            'memberDrawn' => $memberDrawn,
        ]);
    }

}
