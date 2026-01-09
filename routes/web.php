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

// --- GENERAL & PROFILE ---
    Route::get('/explore', function () {
        $communities = \App\Models\Community::withCount('subscribers')->get(); 
        return view('home.explore', compact('communities'));
    })->name('explore');

    Route::get('/rules', function () { return view('home.rule'); });
    Route::get('/profile', function () { return view('profile'); });
    Route::post('/logout', [brain::class, 'logout'])->name('logout.post');

    // --- COMMUNITY ROUTES ---
    Route::get('/communityCreate', [brain::class, 'createCommunity'])->name('community.create');
    Route::post('/create-community', [brain::class, 'postCommunity'])->name('community.create.post');
    Route::get('/view-community/{id}', [brain::class, 'viewCommunity'])->name('community.view');
    Route::get('/join-community/{id}', [brain::class, 'joinCommunity'])->name('community.join');
    Route::get('/c/{id}/settings', [brain::class, 'settings'])->name('community.settings');
    Route::post('/c/{id}/role', [brain::class, 'updateRole'])->name('community.updateRole');
    
    // ** CRITICAL: Using New Branch 'updateIcon' (PUT) because we fixed the Controller for this **
    Route::put('/community/{id}/update-icon', [brain::class, 'updateIcon'])->name('community.updateIcon');

    // ** CRITICAL: Using Main Branch 'transferOwnership' because we kept that feature **
    Route::post('/c/{id}/transfer', [brain::class, 'transferOwnership'])->name('community.transfer');

    // --- POST ROUTES ---
    // ** CRITICAL: We kept Main Branch's 'storePost' function, so we must use these routes **
    Route::get('/post/create', [brain::class, 'createPost'])->name('post.create');
    Route::post('/post/create', [brain::class, 'storePost'])->name('post.store'); // Matches 'storePost' in controller
    
    Route::get('/post/{id}/edit', [brain::class, 'editPost'])->name('post.edit');
    Route::put('/post/{id}', [brain::class, 'updatePost'])->name('post.update');
    Route::delete('/post/{id}', [brain::class, 'deletePost'])->name('post.destroy');
    Route::post('/vote', [brain::class, 'vote'])->name('post.vote');
    
    // --- SEARCH ---
    Route::get('/search', [brain::class, 'search'])->name('search');

    // --- ADMIN & REPORTS (Main Branch Features) ---
    Route::get('/admin/dashboard', [brain::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/report', [brain::class, 'activityReport'])->name('admin.report');
    Route::post('/admin/ban/{id}', [brain::class, 'adminBanUser'])->name('admin.ban');
    Route::delete('/admin/community/{id}', [brain::class, 'adminDeleteCommunity'])->name('admin.community.delete');

    // --- RULE MANAGEMENT (New Branch Features) ---
    Route::post('/community/{community_id}/rules', [brain::class, 'rule'])->name('rules.view');
    Route::post('/community/{community_id}/rules/post', [brain::class, 'postRule'])->name('rules.store');
    Route::put('/rules/{rule_id}', [brain::class, 'updateRule'])->name('rules.update');
    Route::delete('/rules/{rule_id}', [brain::class, 'destroyRule'])->name('rules.destroy');

});
