<?php

namespace App\Rules;

use App\Models\Member;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueWithInSession implements ValidationRule
{
    public function __construct(private array $uniqueAttributes)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $uniqueFields = [$attribute => $value];
        foreach ($this->uniqueAttributes as $uniqueAttribute) {
            $uniqueFields[('members.' . $uniqueAttribute)] = request($uniqueAttribute);
        }
        if (
            Member::where($uniqueFields)
            ->join('lottery_sessions', 'members.lottery_session_id', '=', 'lottery_sessions.id')
            ->where('lottery_sessions.session_name', '=', request()->route('lotterySessionName'))
            ->count()
        ) {
            $uniqueAttributeString = implode(', ', $this->uniqueAttributes);
            $fail('The :attribute with '.$uniqueAttributeString.' must be unique.');
        }
    }
}
