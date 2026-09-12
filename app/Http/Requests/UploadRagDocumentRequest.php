<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRagDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, string>> */
    public function rules(): array
    {
        return [
            'document' => ['required', 'file', 'mimes:pdf,txt,md,docx', 'extensions:pdf,txt,md,docx', 'max:5120'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'document.required' => 'Choose a document to start chatting.',
            'document.mimes' => 'Upload a PDF, TXT, Markdown, or DOCX file.',
            'document.extensions' => 'Upload a PDF, TXT, Markdown, or DOCX file.',
            'document.max' => 'The document must be 5 MB or smaller.',
        ];
    }
}
