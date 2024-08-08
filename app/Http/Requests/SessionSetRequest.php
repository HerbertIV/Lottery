<?php

namespace App\Http\Requests;

use App\Models\Member;
use App\Rules\MemberInSession;
use App\Services\Contracts\MembersServiceContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;

class SessionSetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'session' => [
                'required',
                'string',
                'max:255',
                'exists:lottery_sessions,session_name'
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                new MemberInSession($this->input('name'), $this->input('session'))
            ]
        ];
    }

    public function messages()
    {
        return [
            'session.required' => 'Sesja jest wymagane',
            'session.string' => 'Sesja musi być ciągiem znaków',
            'session.max' => 'Maksymalna długość w polu kod sesji nie może przekraczać :max',
            'session.exists' => 'Ta sesja nie ma takiego członka',
            'name.required' => 'Imię i nazwisko jest wymagane',
            'name.string' => 'Imię i nazwisko musi być ciągiem znaków',
            'name.max' => 'Maksymalna długość w polu Imię i nazwisko nie może przekraczać :max',
            'name.exists' => 'Taki członek nie należy do żadnej sesji',
        ];
    }
}
