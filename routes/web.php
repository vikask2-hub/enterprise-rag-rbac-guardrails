<?php

use App\Http\Controllers\EnterpriseRagController;
use Illuminate\Support\Facades\Route;

Route::redirect('/portfolio', 'https://tech4projects.online/')->name('portfolio');
Route::redirect('/', '/rag');

Route::controller(EnterpriseRagController::class)->prefix('rag')->name('rag.')->group(function (): void {
    Route::get('/', 'index')->name('index');
    Route::post('/document', 'upload')->middleware('throttle:10,1')->name('document.upload');
    Route::post('/ask', 'ask')->middleware('throttle:12,1')->name('ask');
    Route::post('/reset', 'reset')->name('reset');
});
