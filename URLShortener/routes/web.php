<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to URLShortener. Please use API to use the system'], 200);
});

// PUBLIC REDIRECTION ENDPOINT
Route::get('/{short_code}', [UrlController::class, 'redirect']);