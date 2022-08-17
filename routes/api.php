<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\SignUpController;

Route::post('signUp', SignUpController::class);
Route::post('signIn', SignInController::class);
