<?php

namespace App\Rules;

use App\Models\LotterySessionTurn;
use App\Models\Member;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class LotterySessionTurnDateRangeNotCollision implements ValidationRule
{
    public function __construct(
        private readonly ?string $dateStartAttribute = null,
        private readonly ?string $dateEndAttribute = null
    ) {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $dateStartAttribute = $this->dateStartAttribute ?: $attribute;
        $dateEndAttribute = $this->dateEndAttribute ?: 'date_to';
        $dateStartValue = request()->input($dateStartAttribute);
        $dateEndValue = request()->input($dateEndAttribute);
        DB::enableQueryLog();
        if (LotterySessionTurn::query()
            ->where([
                ['date_from', '<=', $dateEndValue],
                ['date_to', '>=', $dateStartValue],
                ['lottery_session_id', '=', request()->route('lotterySession')],
            ])->count() > 0) {
            $fail('The collision date exists.');
        }
    }
}
