<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSessionRequest;
use App\Http\Requests\DestroyMemberRequest;
use App\Http\Requests\MemberStoreRequest;
use App\Http\Requests\SendDrawnMemberRequest;
use App\Http\Requests\StoreSessionRequest;
use App\Models\Member;
use App\Services\Contracts\LotterySessionServiceContract;
use App\Services\Contracts\MembersServiceContract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ManageLotteryController extends Controller
{
    public function __construct(
        private MembersServiceContract $membersService,
        private LotterySessionServiceContract $lotterySessionService
    ) {
    }

    public function store(StoreSessionRequest $request): RedirectResponse|Redirector
    {
        $session = $this->lotterySessionService->generate();
        return redirect(
            route('session.show', [
                'session' => $session->session_name
            ])
        );
    }

    public function create(CreateSessionRequest $request): View
    {
        return view('create');
    }

    public function storeMember(MemberStoreRequest $request, string $session): View
    {
        $lotterySession = $this->lotterySessionService->getSessionByName($session);
        $this->membersService->store($lotterySession, $request);
        $lotterySession->refresh();
        return view('session', [
            'members' => $lotterySession->members,
            'membersCanDraw' => $lotterySession->membersCanDraw,
            'membersCanNotDraw' => $lotterySession->membersCanNotDraw,
            'session' => $session
        ]);
    }

    public function destroyMember(DestroyMemberRequest $request, string $session, Member $member): RedirectResponse|Redirector
    {
        $this->membersService->destroy($member);

        return redirect(
            route('session.show', ['session' => $session])
        );
    }

    public function sendDrawnMember(SendDrawnMemberRequest $request, string $session, Member $member): RedirectResponse|Redirector
    {
        $this->membersService->sendDrawnMember($member, $session);

        return redirect(route('session.show', [$session]));
    }
}
