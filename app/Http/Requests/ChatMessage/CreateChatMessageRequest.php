<?php

namespace App\Http\Requests\ChatMessage;

use Illuminate\Foundation\Http\FormRequest;

final class CreateChatMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'newMessage' => ['required', 'string', 'max:255']
        ];
    }
}
