<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberStoreRequest;
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
        private MembersServiceContract $membersService,
        private LotterySessionServiceContract $lotterySessionService
    ) {
    }

    public function render(): View
    {
        return view('home', [
            'loterrySessions' => LotterySession::all()
        ]);
    }

    public function setSession(SessionSetRequest $sessionSetRequest)
    {
        $member = $this->membersService->getMemberByName($sessionSetRequest->input('name'));
        return redirect(
            route('session.lottery', [
                'session' => $sessionSetRequest->input('session'),
                'member' => $member
            ])
        );
    }

    public function show(string $session): View
    {
        $lotterySession = $this->lotterySessionService->getSessionByName($session);

        return view('session', [
            'members' => $lotterySession->members,
            'membersCanDraw' => $lotterySession->membersCanDraw,
            'membersCanNotDraw' => $lotterySession->membersCanNotDraw,
            'session' => $session
        ]);
    }

    public function lottery(Request $request, string $session, Member $member): View
    {
        return view('lottery', [
            'session' => $session,
            'member' => $member
        ]);
    }

    public function drawMember(Request $request, string $session, Member $member): View
    {
        $memberDrawn = $this->membersService->draw($member, $session);

        return view('lottery', [
            'session' => $session,
            'member' => $member,
            'memberDrawn' => $memberDrawn,
        ]);
    }

    public function sendDrawnMember(Request $request, string $session, Member $member): View
    {
        $memberDrawn = $this->membersService->sendDrawnMember($member, $session);
        dd($memberDrawn);
        return view('lottery', [
            'session' => $session,
            'member' => $member,
            'memberDrawn' => $memberDrawn,
        ]);
    }
}
