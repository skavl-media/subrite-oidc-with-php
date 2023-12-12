<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainContoller;



Route::get('/', [MainContoller::class, 'index']);
Route::get('/login', [MainContoller::class, 'login']);
Route::get('/api/auth/callback', [MainContoller::class, 'callback']);

