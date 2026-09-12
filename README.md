# Enterprise RAG with RBAC & Guardrails

[![Live demo](https://img.shields.io/badge/Live_Demo-tech4projects.online-2563eb?style=for-the-badge)](https://tech4projects.online/rag)
[![Gemini](https://img.shields.io/badge/AI-Google_Gemini-8e75ff?logo=googlegemini)](https://ai.google.dev/)

A single-page document Q&A application: upload a document, then ask grounded questions about its contents. The interface stays intentionally small while the service layer enforces safer enterprise-style behavior.

## Product highlights

- Document-first workflow with chat revealed only after a successful upload
- PDF, DOCX, and text extraction with bounded file size and context length
- Answers grounded in the uploaded document through Google Gemini
- Prompt-injection screening and refusal behavior for unsupported requests
- Session-isolated documents and conversation history
- Mocked AI tests covering upload, validation, grounding, reset, and failure states

## Stack

PHP 8.3+ · Laravel 13 · Google Gemini API · Blade · Tailwind CSS 4 · PHPUnit

## Run locally

```bash
git clone https://github.com/vikask2-hub/enterprise-rag-rbac-guardrails.git
cd enterprise-rag-rbac-guardrails
composer install
cp .env.example .env
php artisan key:generate
# Add GEMINI_API_KEY to .env
npm install && npm run build
php artisan serve
```

The public repository contains no API key or uploaded document data.

---

Built by [Vikas Kaithia](https://github.com/vikask2-hub) · [View the complete product portfolio](https://tech4projects.online/)
