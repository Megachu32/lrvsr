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



