<?php

use App\Http\Controllers\brain;
use App\Models\Community;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

// --- Public Routes (Login/Register must be accessible to everyone) ---
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
});

Route::post('/login', [brain::class, 'login'])->name('login.post');
Route::post('/register', [brain::class, 'register'])->name('register.post');


// --- Protected Routes (Everything else wrapped in Auth) ---
Route::middleware(['auth'])->group(function () {

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

    Route::get('/profile', function () {
        return view('profile');
    });

    Route::post('/logout', [brain::class, 'logout'])->name('logout.post');

    Route::get('/communityCreate', [brain::class, 'createCommunity'])->name('community.create');
    Route::get('/view-community/{id}', [brain::class, 'viewCommunity'])->name('community.view');
    Route::get('/join-community/{id}', [brain::class, 'joinCommunity'])->name('community.join');
    Route::post('/create-community', [brain::class, 'postCommunity'])->name('community.create.post');
    Route::put('/community/{id}/update-icon', [brain::class, 'updateIcon'])->name('community.updateIcon');

    Route::get('/postCreate', [brain::class, 'createPost'])->name('post.create');
    Route::get('/post/{id}/edit', [brain::class, 'editPost'])->name('post.edit');
    Route::put('/post/{id}', [brain::class, 'updatePost'])->name('post.update');
    Route::post('/create-post', [brain::class, 'postPost'])->name('post.create.post');
    Route::delete('/post/{id}', [brain::class, 'deletePost'])->name('post.destroy');

    Route::get('/search', [brain::class, 'search'])->name('search');
    Route::get('/c/{id}/settings', [brain::class, 'settings'])->name('community.settings');
    Route::get('/admin/dashboard', [brain::class, 'adminDashboard'])->name('admin.dashboard');
    Route::post('/vote', [brain::class, 'vote'])->name('post.vote');
    Route::post('/c/{id}/role', [brain::class, 'updateRole'])->name('community.updateRole');

    // Rule Management
    Route::post('/community/{community_id}/rules', [brain::class, 'rule'])->name('rules.view');
    Route::post('/community/{community_id}/rules/post', [brain::class, 'postRule'])->name('rules.store');
    Route::put('/rules/{rule_id}', [brain::class, 'updateRule'])->name('rules.update');
    Route::delete('/rules/{rule_id}', [brain::class, 'destroyRule'])->name('rules.destroy');

});