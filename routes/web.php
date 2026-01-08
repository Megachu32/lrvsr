<?php

use App\Http\Controllers\brain;
use App\Models\Community;
use App\Models\Post;
use Illuminate\Support\Facades\Route;


Route::get('/', [brain::class, 'home'])->name('home');

Route::get('/community', function () {

    return view('community.index');
})->name('community.list');

Route::get('/explore', function () {
        $communities = Community::withCount('subscribers')->get(); 

    return view('home.explore', compact('communities'));
})->name('explore');

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


// =section for CURD=


// The route that the LOGIN form sends data to
Route::post('/login', [Brain::class, 'login'])->name('login.post');

// The route that the REGISTER form sends data to
Route::post('/register', [Brain::class, 'register'])->name('register.post');

Route::post('/logout', [Brain::class, 'logout'])->name('logout.post');

Route::get('/communityCreate', [brain::class, 'createCommunity'])->name('community.create');

Route::get('/postCreate', [brain::class, 'createPost'])->name('post.create');

Route::post('/create-community', [Brain::class, 'postCommunity'])->name('community.create.post');

Route::post('/create-post', [Brain::class, 'postPost'])->name('post.create.post');

Route::get('/view-community/{id}', [Brain::class, 'viewCommunity'])->name('community.view');

Route::get('/join-community/{id}', [Brain::class, 'joinCommunity'])->name('community.join');

Route::post('/vote', [brain::class, 'vote'])->name('post.vote');

Route::get('/search', [App\Http\Controllers\brain::class, 'search'])->name('search');

Route::get('/post/{id}/edit', [brain::class, 'editPost'])->name('post.edit');

// Handle the update (saving changes)
Route::put('/post/{id}', [brain::class, 'updatePost'])->name('post.update');

// Handle deletion
Route::delete('/post/{id}', [brain::class, 'deletePost'])->name('post.destroy');

Route::get('/c/{id}/settings', [brain::class, 'settings'])->name('community.settings');

Route::post('/c/{id}/role', [brain::class, 'updateRole'])->name('community.updateRole');

Route::get('/admin/dashboard', [brain::class, 'adminDashboard'])->name('admin.dashboard');