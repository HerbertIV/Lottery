<?php

namespace App\Http\Requests;

use App\Models\LotterySessionTurn;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DrawMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return LotterySessionTurn::query()
            ->join('lottery_sessions', 'lottery_sessions.id', '=', 'lottery_session_turns.lottery_session_id')
            ->where('lottery_sessions.session_name', '=', $this->route('lotterySessionName'))
            ->activeSession()
            ->count() > 0;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [];
    }
}
