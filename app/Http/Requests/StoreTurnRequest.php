<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTurnRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'date_from' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:date_to'],
            'date_to' =>['required', 'date', 'date_format:Y-m-d', 'after_or_equal:date_from'],
        ];
    }
}
