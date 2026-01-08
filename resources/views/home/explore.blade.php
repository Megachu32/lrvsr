@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="mb-4">
        <h5 class="fw-bold mb-3">Explore Topics</h5>
        <div class="d-flex gap-2 flex-wrap">
            <a href="#" class="btn btn-light rounded-pill border fw-bold text-primary border-primary">For You</a>
            <a href="#" class="btn btn-light rounded-pill border fw-bold text-secondary">Gaming</a>
            <a href="#" class="btn btn-light rounded-pill border fw-bold text-secondary">Sports</a>
            <a href="#" class="btn btn-light rounded-pill border fw-bold text-secondary">Technology</a>
            <a href="#" class="btn btn-light rounded-pill border fw-bold text-secondary">Crypto</a>
            <a href="#" class="btn btn-light rounded-pill border fw-bold text-secondary">Television</a>
            <a href="#" class="btn btn-light rounded-pill border fw-bold text-secondary">Celebrity</a>
        </div>
    </div>

    <div class="mb-5">
        <h5 class="fw-bold mb-3">Trending Communities</h5>
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="bg-primary rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px; font-size: 24px;">
                            <i class="fa-solid fa-gamepad"></i>
                        </div>
                        <h6 class="fw-bold mb-0">r/Gaming</h6>
                        <small class="text-secondary">32m Members</small>
                        <button class="btn btn-outline-primary rounded-pill btn-sm w-100 mt-2 fw-bold">Join</button>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="bg-danger rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px; font-size: 24px;">
                            <i class="fa-solid fa-basketball"></i>
                        </div>
                        <h6 class="fw-bold mb-0">r/NBA</h6>
                        <small class="text-secondary">8.2m Members</small>
                        <button class="btn btn-outline-primary rounded-pill btn-sm w-100 mt-2 fw-bold">Join</button>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="bg-success rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px; font-size: 24px;">
                            <i class="fa-solid fa-robot"></i>
                        </div>
                        <h6 class="fw-bold mb-0">r/ArtificialIntell...</h6>
                        <small class="text-secondary">1.2m Members</small>
                        <button class="btn btn-outline-primary rounded-pill btn-sm w-100 mt-2 fw-bold">Join</button>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="bg-warning rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px; font-size: 24px;">
                            <i class="fa-brands fa-bitcoin"></i>
                        </div>
                        <h6 class="fw-bold mb-0">r/CryptoCurrency</h6>
                        <small class="text-secondary">6.5m Members</small>
                        <button class="btn btn-outline-primary rounded-pill btn-sm w-100 mt-2 fw-bold">Join</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h5 class="fw-bold mb-3">Popular Posts Right Now</h5>
    <div class="row">
        
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="bg-secondary" style="height: 150px; background-image: url('https://placehold.co/600x400/grey/white?text=Cat+Pic'); background-size: cover;"></div>
                <div class="card-body">
                    <h6 class="fw-bold">My cat finally caught the red dot!</h6>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <small class="text-secondary">r/aww • 2h ago</small>
                        <small class="fw-bold"><i class="fa-solid fa-arrow-up text-danger"></i> 15k</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="fw-bold">Unpopular Opinion: The new update is actually good.</h6>
                    <p class="card-text small text-secondary mt-2">I know everyone hates it, but if you look at the patch notes...</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-secondary">r/gaming • 5h ago</small>
                        <small class="fw-bold"><i class="fa-solid fa-arrow-up text-danger"></i> 3.2k</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100">
                 <div class="bg-secondary" style="height: 150px; background-image: url('https://placehold.co/600x400/2c3e50/white?text=Setup'); background-size: cover;"></div>
                <div class="card-body">
                    <h6 class="fw-bold">Finally finished my dream desk setup</h6>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <small class="text-secondary">r/battlestations • 1h ago</small>
                        <small class="fw-bold"><i class="fa-solid fa-arrow-up text-danger"></i> 8.9k</small>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection