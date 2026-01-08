@extends('layouts.app')

@section('content')
<div class="card border-0 mb-3">
    <div class="bg-primary" style="height: 100px; border-radius: 4px 4px 0 0;"></div>
    
    <div class="card-body d-flex align-items-end pb-2" style="margin-top: -30px;">
        <div class="bg-white rounded-circle p-1">
            <div class="bg-dark rounded-circle d-flex align-items-center justify-content-center text-white border border-4 border-white" style="width: 70px; height: 70px; font-size: 30px;">
                <i class="fa-solid fa-rocket"></i>
            </div>
        </div>
        
        <div class="ms-3 mb-1 d-flex justify-content-between w-100 align-items-end">
            <div>
                <h3 class="fw-bold mb-0">r/{{ $name ?? 'topic' }}</h3>
                <div class="text-secondary small">r/{{ $name ?? 'topic' }}</div>
            </div>
            <button class="btn btn-primary rounded-pill px-4 fw-bold">Join</button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        
        <div class="card p-2 d-flex flex-row align-items-center mb-3">
            <div class="bg-secondary rounded-circle ms-2" style="width: 38px; height: 38px;"></div>
            <input type="text" class="form-control ms-2" placeholder="Create Post in r/{{ $name ?? 'topic' }}" style="background-color: #F6F7F8;">
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

        <div class="card d-flex flex-row border-success mb-3">
            <div class="vote-section d-flex flex-column align-items-center p-2 bg-light">
                <i class="fa-solid fa-arrow-up vote-btn mb-1"></i>
                <span class="fw-bold my-1">402</span>
                <i class="fa-solid fa-arrow-down vote-btn mt-1"></i>
            </div>
            <div class="p-2 w-100">
                <div class="mb-1">
                    <span class="text-success fw-bold"><i class="fa-solid fa-thumbtack"></i> Pinned by Moderators</span>
                    <span class="meta-text ms-2">• Posted by u/ModTeam 1 year ago</span>
                </div>
                <h5 class="card-title fw-bold">Welcome to r/{{ $name ?? 'topic' }}! Read the rules first.</h5>
                <div class="d-flex gap-3 mt-2">
                    <button class="btn btn-light btn-sm text-secondary fw-bold"><i class="fa-regular fa-comment-alt"></i> 10 Comments</button>
                    <button class="btn btn-light btn-sm text-secondary fw-bold"><i class="fa-solid fa-share"></i> Share</button>
                </div>
            </div>
        </div>

        <div class="card d-flex flex-row">
            <div class="vote-section d-flex flex-column align-items-center p-2 bg-light">
                <i class="fa-solid fa-arrow-up vote-btn mb-1"></i>
                <span class="fw-bold my-1">1.2k</span>
                <i class="fa-solid fa-arrow-down vote-btn mt-1"></i>
            </div>
            <div class="p-2 w-100">
                <div class="mb-1">
                    <span class="meta-text">Posted by u/FanBoy 4 hours ago</span>
                </div>
                <h5 class="card-title fw-bold">This framework is amazing</h5>
                <p class="card-text">I just started using this and the speed is incredible compared to...</p>
                <div class="d-flex gap-3 mt-2">
                    <button class="btn btn-light btn-sm text-secondary fw-bold"><i class="fa-regular fa-comment-alt"></i> 342 Comments</button>
                    <button class="btn btn-light btn-sm text-secondary fw-bold"><i class="fa-solid fa-share"></i> Share</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 d-none d-md-block">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white fw-bold">About Community</div>
            <div class="card-body">
                <p class="card-text">A community dedicated to the {{ $name ?? 'topic' }} topic. Discuss, share, and learn.</p>
                
                <div class="d-flex mb-3">
                    <div class="me-4">
                        <div class="fw-bold">152k</div>
                        <div class="text-secondary small">Members</div>
                    </div>
                    <div>
                        <div class="fw-bold">420</div>
                        <div class="text-secondary small">Online</div>
                    </div>
                </div>

                <hr>
                <div class="mb-3">
                    <div class="small text-secondary"><i class="fa-solid fa-cake-candles"></i> Created Jan 24, 2012</div>
                </div>

                <button class="btn btn-primary w-100 rounded-pill mb-2">Create Post</button>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-light fw-bold small">r/{{ $name ?? 'topic' }} Rules</div>
            <ol class="list-group list-group-numbered list-group-flush small">
                <li class="list-group-item">Be kind and respectful</li>
                <li class="list-group-item">Keep posts on topic</li>
                <li class="list-group-item">No reposts within 30 days</li>
            </ol>
        </div>
    </div>
</div>
@endsection