<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyApiController;
use App\Http\Controllers\Api\TenancyApiController;
use App\Http\Controllers\Api\PaymentApiController;
use App\Http\Controllers\Api\WebhookApiController;
use App\Http\Controllers\Api\AuthApiController;

Route::post('login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('properties', PropertyApiController::class);
    Route::apiResource('tenancies', TenancyApiController::class);
    Route::apiResource('payments', PaymentApiController::class);
    Route::apiResource('webhooks', WebhookApiController::class)->only(['index', 'store', 'destroy']);
});
