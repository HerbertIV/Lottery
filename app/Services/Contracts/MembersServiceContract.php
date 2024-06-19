<?php

namespace App\Services\Contracts;

use App\Http\Requests\MemberStoreRequest;

interface MembersServiceContract
{
    public function store(MemberStoreRequest $request);
}
