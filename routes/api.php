<?php

use App\Http\Controllers\Authcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/loggedUser', [Authcontroller::class, 'getLoggedUser']);
// });

Route::post('/register', [Authcontroller::class, 'register']);

Route::post('/login', [Authcontroller::class, 'login']);

Route::post('/logout', [Authcontroller::class, 'logout']);
;

Route::get('/loggedUser', [Authcontroller::class, 'getLoggedUser']);
