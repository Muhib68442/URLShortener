<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//////////////////////////////////////////


// REGISTER 
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'register_post']);

// LOGIN 
Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'login_post']);

// PUBLIC REDIRECTION ENDPOINT (Used in Web.php)
// Route::get('/{short_code}', [UrlController::class, 'redirect']);

// ============================= AUTH MIDDLEWARE STARTS FROM HERE ========================================================>
Route::group(['middleware' => 'auth:sanctum'], function () {

    // CHECK AUTH STATUS 
    Route::get('check', [AuthController::class, 'check']);

    // LOGOUT
    Route::get('/logout', [AuthController::class, 'logout']);

    // USER MANAGEMENT SECTION 
    Route::get('/user', [UserController::class, 'view_profile']);
    Route::patch('/user', [UserController::class, 'update_profile']);
    Route::delete('/user', [UserController::class, 'delete_profile']);

    // URL MANAGEMENT SECTION
    Route::get('/urls', [UrlController::class, 'list_urls']);
    Route::post('/urls', [UrlController::class, 'create_url']);
    Route::get('/urls/{url}', [UrlController::class, 'view_url']);
    Route::patch('/urls/{url}', [UrlController::class, 'update_url']);
    Route::delete('/urls/{url}', [UrlController::class, 'delete_url']);



    // NOTE : /{url} IDOR issue possible
});
// ============================= AUTH MIDDLEWARE ENDS HERE ================================================================>
