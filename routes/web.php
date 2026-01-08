<?php

use App\Http\Controllers\brain;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
})->name('home');

Route::get('/community', function () {
    return view('community.index');
});

Route::get('/explore', function () {
    return view('home.explore');
});

Route::get('/rules', function () {
    return view('home.rule');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
});

Route::get('/profile', function () {
    return view('profile');
});


// The route that the LOGIN form sends data to
Route::post('/login', [Brain::class, 'login'])->name('login.post');

// The route that the REGISTER form sends data to
Route::post('/register', [Brain::class, 'register'])->name('register.post');

Route::post('/logout', [Brain::class, 'logout'])->name('logout.post');

