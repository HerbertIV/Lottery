<?php

namespace App\Http\Requests;

use App\Rules\UniqueWith;
use Illuminate\Foundation\Http\FormRequest;

class MemberStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', new UniqueWith(['phone'])],
            'phone' => ['required', 'string', 'max:9', 'regex:/^\d{9}$/', new UniqueWith(['name'])],
        ];
    }
}
