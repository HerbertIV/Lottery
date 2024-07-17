<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberStoreRequest;
use App\Http\Requests\SessionSetRequest;
use App\Models\LotterySession;
use App\Models\Member;
use App\Services\Contracts\MembersServiceContract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LotteryController extends Controller
{
    public function __construct(
        private MembersServiceContract $membersService
    ) {
    }

    public function render(): View
    {
        return view('home');
    }

    public function setSession(SessionSetRequest $sessionSetRequest)
    {
        return redirect(
            route('session.show', ['session' => $sessionSetRequest->input('session')])
        );
    }

    public function show(string $session): View
    {
        $lotterySession = LotterySession::whereSessionName($session)->first();
        return view('session', [
            'members' => $lotterySession->members,
            'membersWasDrawn' => $lotterySession->membersWasDrawn,
            'membersHasDrawn' => $lotterySession->membersHasDrawn,
            'session' => $session
        ]);
    }

    public function store(MemberStoreRequest $request, string $session): View
    {
        $lotterySession = LotterySession::whereSessionName($session)->first();
        $this->membersService->store($lotterySession, $request);
        $lotterySession->refresh();
        return view('session', [
            'members' => $lotterySession->members,
            'session' => $session
        ]);
    }

    public function destroy(Request $request, string $session, Member $member)
    {
        $this->membersService->destroy($member);
        return redirect(
            route('session.show', ['session' => $session])
        );
    }
}
