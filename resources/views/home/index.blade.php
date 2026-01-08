@extends('layouts.app')

@section('content')
<div class="row justify-content-center">

    <div class="col-md-3 d-none d-lg-block">
        <div class="card border-0 bg-transparent">
            <div class="card-body p-0">
                <nav class="nav flex-column gap-2">
                    <a href="" class="nav-link text-dark bg-light rounded mb-1">
                        <i class="fa-solid fa-house me-2"></i> Home
                    </a>
                    <a href="#" class="nav-link text-secondary">
                        <i class="fa-solid fa-arrow-trend-up me-2"></i> Popular
                    </a>
                    <a href="#" class="nav-link text-secondary">
                        <i class="fa-solid fa-plus me-2"></i> Create Post
                    </a>

                    <hr class="my-2 text-secondary">

                    <p class="text-uppercase text-secondary fw-bold small px-3 mb-1" style="font-size: 11px;">Communities</p>
                    <a href="#" class="nav-link text-secondary d-flex justify-content-between align-items-center">
                        <span><i class="fa-solid fa-gamepad me-2"></i> r/gaming</span>
                    </a>
                    <a href="#" class="nav-link text-secondary d-flex justify-content-between align-items-center">
                        <span><i class="fa-solid fa-code me-2"></i> r/laravel</span>
                    </a>
                    <a href="#" class="nav-link text-secondary d-flex justify-content-between align-items-center">
                        <span><i class="fa-solid fa-basketball me-2"></i> r/nba</span>
                    </a>

                    <hr class="my-2 text-secondary">

                    <p class="text-uppercase text-secondary fw-bold small px-3 mb-1" style="font-size: 11px;">Resources</p>
                    <a href="#" class="nav-link text-secondary">
                        <i class="fa-solid fa-book-open me-2"></i> Rules
                    </a>
                    <a href="#" class="nav-link text-secondary">
                        <i class="fa-solid fa-shield-halved me-2"></i> Privacy Policy
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        
        <div class="card p-2 d-flex flex-row align-items-center mb-3">
            <div class="bg-secondary rounded-circle ms-2" style="width: 38px; height: 38px;"></div>
            <input type="text" class="form-control ms-2" placeholder="Create Post" style="background-color: #F6F7F8;">
            <i class="fa-regular fa-image fa-lg ms-3 text-secondary"></i>
            <i class="fa-solid fa-link fa-lg ms-3 text-secondary"></i>
        </div>

        <div class="card p-2 mb-3">
            <div class="d-flex gap-3">
                <a href="#" class="text-decoration-none fw-bold text-dark"><i class="fa-solid fa-fire text-danger"></i> Hot</a>
                <a href="#" class="text-decoration-none text-secondary fw-bold">New</a>
                <a href="#" class="text-decoration-none text-secondary fw-bold">Top</a>
            </div>
        </div>

        <div class="card d-flex flex-row">
            <div class="vote-section d-flex flex-column align-items-center p-2 bg-light">
                <i class="fa-solid fa-arrow-up vote-btn mb-1"></i>
                <span class="fw-bold my-1">12.5k</span>
                <i class="fa-solid fa-arrow-down vote-btn mt-1"></i>
            </div>
            
            <div class="p-2 w-100">
                <div class="mb-1">
                    <span class="subreddit-text">r/laravel</span>
                    <span class="meta-text">• Posted by u/DevMaster 5 hours ago</span>
                </div>
                <h5 class="card-title fw-bold">How to fix 500 server error?</h5>
                <p class="card-text">I am trying to run my project but I keep getting a white screen...</p>
                <div class="d-flex gap-3 mt-2">
                    <button class="btn btn-light btn-sm text-secondary fw-bold"><i class="fa-regular fa-comment-alt"></i> 45 Comments</button>
                    <button class="btn btn-light btn-sm text-secondary fw-bold"><i class="fa-solid fa-share"></i> Share</button>
                    <button class="btn btn-light btn-sm text-secondary fw-bold"><i class="fa-regular fa-bookmark"></i> Save</button>
                </div>
            </div>
        </div>

        <div class="card d-flex flex-row">
            <div class="vote-section d-flex flex-column align-items-center p-2 bg-light">
                <i class="fa-solid fa-arrow-up vote-btn mb-1"></i>
                <span class="fw-bold my-1">842</span>
                <i class="fa-solid fa-arrow-down vote-btn mt-1"></i>
            </div>
            <div class="p-2 w-100">
                <div class="mb-1">
                    <span class="subreddit-text">r/webdev</span>
                    <span class="meta-text">• Posted by u/JuniorDev 8 hours ago</span>
                </div>
                <h5 class="card-title fw-bold">Just launched my first portfolio!</h5>
                <div class="bg-dark text-white p-5 text-center mb-2 rounded">
                    [Placeholder for Image/Video]
                </div>
                <div class="d-flex gap-3 mt-2">
                    <button class="btn btn-light btn-sm text-secondary fw-bold"><i class="fa-regular fa-comment-alt"></i> 120 Comments</button>
                    <button class="btn btn-light btn-sm text-secondary fw-bold"><i class="fa-solid fa-share"></i> Share</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 d-none d-lg-block">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white fw-bold">About Community</div>
            <div class="card-body">
                <p class="card-text">Welcome to the Laravel Reddit Clone! A place to learn routing, controllers, and views.</p>
                <hr>
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="fw-bold">1.2m</div>
                        <div class="text-secondary small">Members</div>
                    </div>
                    <div>
                        <div class="fw-bold">450</div>
                        <div class="text-secondary small">Online</div>
                    </div>
                </div>
                <a href="#" class="btn btn-primary w-100 mt-3 rounded-pill">Create Post</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-light fw-bold small text-uppercase">r/Laravel Rules</div>
            <ul class="list-group list-group-flush small">
                <li class="list-group-item">1. Be respectful to others.</li>
                <li class="list-group-item">2. No spam or self-promotion.</li>
                <li class="list-group-item">3. Post relevant content only.</li>
            </ul>
        </div>
    </div>

</div>
@endsection