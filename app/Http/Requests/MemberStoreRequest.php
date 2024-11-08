<?php

namespace App\Http\Requests;

use App\Rules\UniqueWithInSession;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MemberStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', new UniqueWithInSession(['phone'])],
            'phone' => ['required_without:email', 'string', 'max:9', 'regex:/^\d{9}$/', new UniqueWithInSession(['name'])],
            'email' => ['required_without:phone', 'nullable', 'email', new UniqueWithInSession(['name'])],
        ];
    }
}
