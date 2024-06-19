<?php

namespace App\Services;

use App\Http\Requests\MemberStoreRequest;
use App\Models\Member;
use App\Services\Contracts\MembersServiceContract;

class MembersService implements MembersServiceContract
{

    public function store(MemberStoreRequest $request)
    {
        $member = new Member();
        $member->name = $request->name;
        return $member->save();
    }
}
