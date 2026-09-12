<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskRagQuestionRequest;
use App\Http\Requests\UploadRagDocumentRequest;
use App\Services\EnterpriseRagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EnterpriseRagController extends Controller
{
    public function index(Request $request): View
    {
        return view('enterprise-rag', [
            'document' => $request->session()->get('rag_document'),
            'history' => $request->session()->get('rag_history', []),
        ]);
    }

    public function upload(UploadRagDocumentRequest $request): RedirectResponse
    {
        $file = $request->file('document');
        $previousDocument = $request->session()->get('rag_document');
        $path = $file->store('rag-documents/'.$request->session()->getId(), 'local');

        if ($path === false) {
            return back()->withErrors(['document' => 'The document could not be uploaded. Please try again.']);
        }

        if (is_array($previousDocument)) {
            Storage::disk('local')->delete($previousDocument['path']);
        }

        $request->session()->put('rag_document', [
            'name' => Str::limit(basename($file->getClientOriginalName()), 80),
            'path' => $path,
            'mime' => $this->mimeTypeFor($file->extension()),
            'size' => $file->getSize(),
            'uploaded_at' => now()->format('H:i'),
        ]);
        $request->session()->forget('rag_history');

        return redirect()->route('rag.index')->with('status', 'Document ready. Ask your first question.');
    }

    public function ask(AskRagQuestionRequest $request, EnterpriseRagService $rag): RedirectResponse
    {
        $document = $request->session()->get('rag_document');

        if (! is_array($document) || ! Storage::disk('local')->exists($document['path'])) {
            return redirect()->route('rag.index')->withErrors(['document' => 'Upload a document before asking a question.']);
        }

        $question = $request->string('question')->trim()->toString();
        $result = $rag->answer($document, $question);
        $history = $request->session()->get('rag_history', []);
        $history[] = [
            'question' => $question,
            'answer' => $result['answer'],
            'blocked' => $result['blocked'],
            'created_at' => now()->format('H:i'),
        ];
        $request->session()->put('rag_history', array_slice($history, -10));

        return redirect()->route('rag.index');
    }

    public function reset(Request $request): RedirectResponse
    {
        $document = $request->session()->get('rag_document');

        if (is_array($document)) {
            Storage::disk('local')->delete($document['path']);
        }

        $request->session()->forget(['rag_document', 'rag_history']);

        return redirect()->route('rag.index');
    }

    private function mimeTypeFor(string $extension): string
    {
        return match (Str::lower($extension)) {
            'pdf' => 'application/pdf',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'md' => 'text/markdown',
            default => 'text/plain',
        };
    }
}
