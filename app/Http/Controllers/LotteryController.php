<?php

namespace App\Http\Controllers;

use App\Http\Requests\DrawMemberRequest;
use App\Http\Requests\SessionSetRequest;
use App\Models\LotterySession;
use App\Models\Member;
use App\Services\Contracts\LotterySessionServiceContract;
use App\Services\Contracts\MembersServiceContract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LotteryController extends Controller
{
    public function __construct(
        private readonly MembersServiceContract $membersService,
        private readonly LotterySessionServiceContract $lotterySessionService
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
        $member = $this->membersService->getMemberByName($sessionSetRequest->input('name'));
        return redirect(
            route('lottery-session.lottery', [
                'lotterySessionName' => $sessionSetRequest->input('session_name'),
                'member' => $member
            ])
        );
    }

    public function show(string $lotterySessionName): View
    {
        $lotterySession = $this->lotterySessionService->getSessionByName($lotterySessionName);

        return view('session', [
            'members' => $lotterySession->members,
            'membersCanDraw' => $this->lotterySessionService->getCanDrawMembersFromActiveTurnInLotterySession($lotterySession),
            'membersCanNotDraw' => $this->lotterySessionService->getCanNotDrawMembersFromActiveTurnInLotterySession($lotterySession),
            'lotterySessionName' => $lotterySessionName,
            'activeSessionTurn' => $lotterySession->activeLotterySessionTurns->first()
        ]);
    }

    public function lottery(Request $request, string $lotterySessionName, Member $member): View
    {
        $lotterySession = $this->lotterySessionService->getSessionByName($lotterySessionName);

        return view('lottery', [
            'activeLotterySessionTurn' => $lotterySession->activeLotterySessionTurns()->first(),
            'lotterySessionName' => $lotterySessionName,
            'member' => $member
        ]);
    }

    public function drawMember(
        DrawMemberRequest $request,
        string $lotterySessionName,
        Member $member
    ): View {
        $memberDrawn = $this->membersService->draw($member, $lotterySessionName);

        return view('lottery', [
            'lotterySessionName' => $lotterySessionName,
            'member' => $member,
            'memberDrawn' => $memberDrawn,
        ]);
    }

}
