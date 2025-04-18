<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\VerificationPharmacien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/loggedUser', [Authcontroller::class, 'getLoggedUser']);
// });

Route::post('/register', [Authcontroller::class, 'register']);

Route::post('/login', [Authcontroller::class, 'login']);

Route::post('/logout', [Authcontroller::class, 'logout']);

Route::get('/loggedUser', [Authcontroller::class, 'getLoggedUser']);


// verification pharmacien
Route::post('/verification-pharmacien/ajout', [VerificationPharmacien::class, 'ajout']);
Route::post('/verification-pharmacien/annuler/{id}', [VerificationPharmacien::class, 'annuler']);
