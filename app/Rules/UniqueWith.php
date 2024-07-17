<?php

namespace App\Rules;

use App\Models\Member;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueWith implements ValidationRule
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
            $uniqueFields[$uniqueAttribute] = request($uniqueAttribute);
        }
        if (Member::where($uniqueFields)->count()) {
            $uniqueAttributeString = implode(', ', $this->uniqueAttributes);
            $fail('The :attribute with '.$uniqueAttributeString.' must be unique.');
        }
    }
}
