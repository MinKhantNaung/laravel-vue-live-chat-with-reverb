<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

final class FilterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string']
        ];
    }
}
