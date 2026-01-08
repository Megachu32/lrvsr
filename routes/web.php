<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
});

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
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/communityCreate', function () {
    return view('community.create');
});

Route::get('/postCreate', function () {
    return view('post.create');
});


