<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AskRagQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, string>> */
    public function rules(): array
    {
        return [
            'question' => ['required', 'string', 'min:3', 'max:500'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'question.required' => 'Enter a question about your document.',
            'question.min' => 'Your question must contain at least 3 characters.',
        ];
    }
}
