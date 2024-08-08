<?php

namespace App\Rules;

use App\Services\Contracts\MembersServiceContract;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MemberInSession implements ValidationRule
{
    public function __construct(private string $memberName, private string $sessionName)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! app(MembersServiceContract::class)->memberInSession($this->memberName, $this->sessionName)) {
            $fail('Ta osoba nie jest członkiem tej sesji losującej.');
        }
    }
}
