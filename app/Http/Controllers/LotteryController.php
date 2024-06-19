<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberStoreRequest;
use App\Models\LotterySession;
use App\Services\Contracts\MembersServiceContract;

class LotteryController extends Controller
{
    public function __construct(
        private MembersServiceContract $membersService
    ) {
    }

    public function show(string $session)
    {
        $lotterySession = LotterySession::whereSessionName($session)->first();
        return view('welcome', [
            'members' => $lotterySession->members
        ]);
    }

    public function store(MemberStoreRequest $request, string $session)
    {
        $lotterySession = LotterySession::whereSessionName($session)->first();
        return view('welcome', [
            'members' => $lotterySession->members
        ]);
    }
}
