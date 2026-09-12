<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Upload a document and ask questions about it with Gemini.">
    <title>VaultMind · Chat with your document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body, button, textarea, input { font-family: Inter, ui-sans-serif, system-ui, sans-serif !important; }</style>
</head>
<body class="min-h-screen bg-[#f7f8fb] pt-16 text-slate-950 antialiased">
    <div class="pointer-events-none fixed inset-x-0 top-0 h-80 bg-[radial-gradient(circle_at_top,rgba(99,102,241,.10),transparent_68%)]"></div>

    <header class="fixed inset-x-0 top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
        <div class="mx-auto flex h-16 max-w-5xl items-center justify-between px-4 sm:px-6">
            <x-portfolio-back-button />
            <span class="text-right"><strong class="block text-[11px] font-extrabold text-slate-800 sm:text-xs">VaultMind</strong><small class="block text-[8px] font-bold tracking-[.1em] text-slate-400 uppercase">Document chat</small></span>
        </div>
    </header>

    <main class="relative mx-auto flex min-h-[calc(100vh-4rem)] max-w-5xl items-center px-4 py-5 sm:px-6 sm:py-6">
        @if(! $document)
            <section class="mx-auto w-full max-w-2xl text-center">
                <span class="inline-flex items-center gap-2 rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1.5 text-[10px] font-bold text-indigo-700"><span class="size-1.5 rounded-full bg-indigo-500"></span> Powered by Gemini</span>
                <h1 class="mt-4 text-4xl font-extrabold tracking-[-.06em] text-slate-950 sm:text-5xl">Chat with your <span class="text-indigo-600">document.</span></h1>
                <p class="mx-auto mt-3 max-w-lg text-sm leading-6 text-slate-500">Upload one document, then ask questions and get clear answers based only on its contents.</p>

                @if($errors->any())
                    <div class="mx-auto mt-5 max-w-xl rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-left text-xs font-semibold text-rose-700">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('rag.document.upload') }}" enctype="multipart/form-data" class="mt-5" id="upload-form">
                    @csrf
                    <label for="document" id="drop-zone" class="group block cursor-pointer rounded-[2rem] border-2 border-dashed border-slate-200 bg-white p-4 shadow-[0_24px_70px_rgba(15,23,42,.08)] transition hover:border-indigo-300 hover:shadow-[0_28px_80px_rgba(79,70,229,.12)] sm:p-5">
                        <span class="mx-auto grid size-12 place-items-center rounded-2xl bg-indigo-50 text-xl transition group-hover:scale-105">↑</span>
                        <strong class="mt-3 block text-base font-extrabold tracking-[-.03em]">Choose a document</strong>
                        <span class="mt-1.5 block text-xs text-slate-400" id="file-label">or drag and drop it here</span>
                        <span class="mt-3 inline-flex rounded-full bg-slate-100 px-3 py-1.5 text-[9px] font-bold text-slate-500">PDF, DOCX, TXT or MD · up to 5 MB</span>
                        <input id="document" name="document" type="file" accept=".pdf,.docx,.txt,.md" required class="sr-only">
                    </label>
                    <button id="upload-button" class="mt-3 inline-flex w-full items-center justify-center rounded-2xl bg-slate-950 px-5 py-3 text-xs font-extrabold text-white shadow-lg shadow-slate-900/15 transition hover:bg-indigo-600 sm:w-auto sm:min-w-48">Upload & continue</button>
                </form>
            </section>
        @else
            <section class="mx-auto flex h-[calc(100vh-7rem)] min-h-[610px] w-full max-w-4xl flex-col overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-[0_30px_90px_rgba(15,23,42,.10)]">
                <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-4 py-4 sm:px-6">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-indigo-50 text-[10px] font-black text-indigo-600">{{ strtoupper(pathinfo($document['name'], PATHINFO_EXTENSION)) }}</span>
                        <div class="min-w-0"><strong class="block truncate text-xs font-extrabold text-slate-800">{{ $document['name'] }}</strong><span class="mt-0.5 block text-[9px] font-medium text-slate-400">{{ number_format($document['size'] / 1024, 0) }} KB · Ready to chat</span></div>
                    </div>
                    <form method="POST" action="{{ route('rag.reset') }}">@csrf<button class="shrink-0 rounded-full border border-slate-200 px-3 py-2 text-[10px] font-bold text-slate-500 transition hover:border-indigo-200 hover:text-indigo-600">New document</button></form>
                </div>

                @if(session('status'))
                    <div class="mx-4 mt-4 rounded-xl bg-emerald-50 px-4 py-2.5 text-center text-[10px] font-bold text-emerald-700 sm:mx-6">{{ session('status') }}</div>
                @endif
                @if($errors->any())
                    <div class="mx-4 mt-4 rounded-xl bg-rose-50 px-4 py-2.5 text-center text-[10px] font-bold text-rose-700 sm:mx-6">{{ $errors->first() }}</div>
                @endif

                <div class="flex-1 space-y-5 overflow-y-auto px-4 py-6 sm:px-8" id="chat-history">
                    @forelse($history as $item)
                        <div class="flex justify-end"><div class="max-w-[82%] rounded-2xl rounded-br-md bg-slate-950 px-4 py-3 text-xs font-medium leading-5 text-white">{{ $item['question'] }}</div></div>
                        <div class="flex items-start gap-3">
                            <span class="grid size-8 shrink-0 place-items-center rounded-xl bg-indigo-600 text-[10px] font-black text-white">V</span>
                            <div class="max-w-[86%]"><div class="rounded-2xl rounded-tl-md {{ $item['blocked'] ? 'bg-amber-50 text-amber-900' : 'bg-slate-100 text-slate-700' }} px-4 py-3 text-xs font-medium leading-5 whitespace-pre-line">{{ $item['answer'] }}</div><span class="mt-1.5 block px-1 text-[8px] font-semibold text-slate-400">{{ $item['created_at'] }}</span></div>
                        </div>
                    @empty
                        <div class="flex h-full flex-col items-center justify-center text-center">
                            <span class="grid size-12 place-items-center rounded-2xl bg-indigo-50 text-xl">✦</span>
                            <h1 class="mt-4 text-xl font-extrabold tracking-[-.04em]">Your document is ready</h1>
                            <p class="mt-2 text-xs text-slate-400">Ask anything about its contents.</p>
                            <div class="mt-5 flex flex-wrap justify-center gap-2">
                                @foreach(['Summarize this document', 'What are the key points?', 'What actions are required?'] as $sample)
                                    <button type="button" data-question="{{ $sample }}" class="sample-question rounded-full border border-slate-200 px-3 py-2 text-[10px] font-semibold text-slate-500 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">{{ $sample }}</button>
                                @endforeach
                            </div>
                        </div>
                    @endforelse
                </div>

                <form method="POST" action="{{ route('rag.ask') }}" class="border-t border-slate-100 bg-white p-3 sm:p-4" id="chat-form">
                    @csrf
                    <div class="flex items-end gap-2 rounded-2xl border border-slate-200 bg-slate-50 p-2 transition focus-within:border-indigo-300 focus-within:bg-white focus-within:ring-4 focus-within:ring-indigo-50">
                        <textarea name="question" rows="1" maxlength="500" required class="max-h-28 min-h-10 flex-1 resize-none bg-transparent px-2 py-2 text-xs font-medium leading-5 outline-none placeholder:text-slate-400" placeholder="Ask anything about this document…">{{ old('question') }}</textarea>
                        <button id="send-button" class="grid size-10 shrink-0 place-items-center rounded-xl bg-indigo-600 text-base font-bold text-white shadow-md shadow-indigo-600/20 transition hover:bg-indigo-700 disabled:opacity-50" aria-label="Send question">↑</button>
                    </div>
                    <p class="mt-2 text-center text-[8px] font-medium text-slate-400">Answers are generated only from your uploaded document.</p>
                </form>
            </section>
        @endif
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('document');
            const fileLabel = document.getElementById('file-label');
            const dropZone = document.getElementById('drop-zone');
            const uploadForm = document.getElementById('upload-form');
            const uploadButton = document.getElementById('upload-button');
            const chatForm = document.getElementById('chat-form');
            const question = chatForm?.querySelector('textarea[name="question"]');
            const chatHistory = document.getElementById('chat-history');

            fileInput?.addEventListener('change', () => { if (fileInput.files[0]) fileLabel.textContent = fileInput.files[0].name; });
            dropZone?.addEventListener('dragover', (event) => { event.preventDefault(); dropZone.classList.add('border-indigo-400', 'bg-indigo-50'); });
            dropZone?.addEventListener('dragleave', () => dropZone.classList.remove('border-indigo-400', 'bg-indigo-50'));
            dropZone?.addEventListener('drop', (event) => { event.preventDefault(); dropZone.classList.remove('border-indigo-400', 'bg-indigo-50'); if (event.dataTransfer.files.length) { fileInput.files = event.dataTransfer.files; fileLabel.textContent = event.dataTransfer.files[0].name; } });
            uploadForm?.addEventListener('submit', () => { uploadButton.disabled = true; uploadButton.textContent = 'Uploading…'; });
            document.querySelectorAll('.sample-question').forEach((button) => button.addEventListener('click', () => { question.value = button.dataset.question; question.focus(); }));
            chatForm?.addEventListener('submit', () => { const button = document.getElementById('send-button'); button.disabled = true; button.textContent = '…'; });
            question?.addEventListener('keydown', (event) => { if (event.key === 'Enter' && ! event.shiftKey) { event.preventDefault(); chatForm.requestSubmit(); } });
            if (chatHistory) chatHistory.scrollTop = chatHistory.scrollHeight;
        });
    </script>
</body>
</html>
