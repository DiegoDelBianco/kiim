<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsappNotificationController;
use App\Http\Controllers\Api\FacebookApiLeadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Whatsapp WebHook
Route::get('/wpp-notification', [WhatsappNotificationController::class, 'webhookGet'])->name('api.webhook.wpp.get');
Route::post('/wpp-notification', [WhatsappNotificationController::class, 'webhookPost'])->name('api.webhook.wpp.post');

Route::get('/facebook-leads', [FacebookApiLeadController::class, 'facebookLeadGet'])->name('api.webhook.facebook.get');
