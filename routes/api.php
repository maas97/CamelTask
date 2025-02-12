<?php

use App\Http\Controllers\AddonListController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SubscriptionListController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:strict')->group(function () {
    Route::post('/register/step1', [RegistrationController::class, 'step1']);
    Route::post('/register/step2', [RegistrationController::class, 'step2']);
    Route::post('/register/step3', [RegistrationController::class, 'step3']);
    Route::post('/register/complete', [RegistrationController::class, 'complete']);

    Route::get('/subscription-lists', [SubscriptionListController::class, 'index']);
    Route::post('/subscription-lists', [SubscriptionListController::class, 'store']);
    Route::put('/subscription-lists/{id}', [SubscriptionListController::class, 'update']);
    Route::delete('/subscription-lists/{id}', [SubscriptionListController::class, 'destroy']);

    Route::get('/addon-lists', [AddonListController::class, 'index']);
    Route::post('/addon-lists', [AddonListController::class, 'store']);
    Route::put('/addon-lists/{id}', [AddonListController::class, 'update']);
    Route::delete('/addon-lists/{id}', [AddonListController::class, 'destroy']);
});



Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});
