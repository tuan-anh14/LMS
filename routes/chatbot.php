<?php

use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Chatbot Routes
|--------------------------------------------------------------------------
|
| Các routes cho tính năng chatbot AI hướng dẫn sử dụng hệ thống
|
*/

Route::prefix('chatbot')->name('chatbot.')->group(function () {
  Route::post('/send-message', [ChatbotController::class, 'sendMessage'])->name('send.message');
  Route::get('/faq', [ChatbotController::class, 'getFAQ'])->name('faq');
  Route::get('/initial-data', [ChatbotController::class, 'getInitialData'])->name('initial.data');
});
