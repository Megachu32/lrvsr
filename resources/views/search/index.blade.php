@extends('layouts.app') @section('content')
<div class="container mt-4">
    
    <div class="mb-4">
        <h3>Search results for "<span class="text-primary">{{ $query }}</span>"</h3>
        
        <ul class="nav nav-pills mt-3">
            <li class="nav-item"><a class="nav-link active rounded-pill" href="#">Posts</a></li>
            <li class="nav-item"><a class="nav-link text-secondary" href="#">Communities</a></li>
            <li class="nav-item"><a class="nav-link text-secondary" href="#">People</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-8">
            @if($posts->count() > 0)
                @foreach($posts as $post)
                    <div class="card mb-3 d-flex flex-row">
                        <div class="d-flex flex-column align-items-center p-2 bg-light border-end" style="width: 50px;">
                            <i class="fa-solid fa-arrow-up text-secondary"></i>
                            <span class="fw-bold my-1 small">{{ $post->votes_sum_vote_type ?? 0 }}</span>
                            <i class="fa-solid fa-arrow-down text-secondary"></i>
                        </div>
                        
                        <div class="p-3 w-100">
                            <div class="mb-1 small text-muted">
                                <img src="{{ $post->community->icon_url ?? 'https://via.placeholder.com/20' }}" class="rounded-circle" style="width: 20px; height: 20px;">
                                <strong class="text-dark">r/{{ $post->community->name }}</strong>
                                <span>• Posted by u/{{ $post->user->username }} {{ $post->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <h5 class="fw-bold mb-1">
                                <a href="#" class="text-decoration-none text-dark">{{ $post->title }}</a>
                            </h5>
                            
                            <p class="text-secondary small mb-2">
                                {{ Str::limit($post->content, 150) }}
                            </p>
                            
                            <div class="text-muted small">
                                <span class="me-3"><i class="fa-regular fa-comment-alt"></i> {{ $post->comments_count }} comments</span>
                                <span><i class="fa-solid fa-share"></i> Share</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-light text-center">No posts found matching "{{ $query }}"</div>
            @endif
        </div>

        <div class="col-md-4">
            
            <div class="card mb-4 border-0 bg-light">
                <div class="card-header bg-transparent border-0 fw-bold">Communities</div>
                <div class="card-body p-0">
                    @forelse($communities as $community)
                        <div class="d-flex align-items-center p-2 border-bottom">
                            <img src="{{ $community->icon_url ?? 'https://via.placeholder.com/40' }}" 
                                 class="rounded-circle me-3" 
                                 style="width: 40px; height: 40px; object-fit: cover;">
                            <div>
                                <div class="fw-bold">r/{{ $community->name }}</div>
                                <div class="small text-muted">{{ Str::limit($community->description, 30) }}</div>
                            </div>
                            <button class="btn btn-primary btn-sm rounded-pill ms-auto">Join</button>
                        </div>
                    @empty
                        <div class="p-3 text-muted small">No communities found.</div>
                    @endforelse
                    
                    @if($communities->count() > 0)
                        <div class="p-2 text-center">
                            <a href="#" class="small text-decoration-none fw-bold">See more communities</a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card border-0 bg-light">
                <div class="card-header bg-transparent border-0 fw-bold">People</div>
                <div class="card-body p-0">
                    @forelse($users as $user)
                        <div class="d-flex align-items-center p-2 border-bottom">
                            <img src="{{ $user->avatar_url ?? 'https://via.placeholder.com/40' }}" 
                                 class="rounded-circle me-3" 
                                 style="width: 40px; height: 40px; object-fit: cover;">
                            <div>
                                <div class="fw-bold">u/{{ $user->username }}</div>
                                <div class="small text-muted">0 Karma</div> </div>
                            <button class="btn btn-outline-primary btn-sm rounded-pill ms-auto">Follow</button>
                        </div>
                    @empty
                         <div class="p-3 text-muted small">No users found.</div>
                    @endforelse
                    
                    @if($users->count() > 0)
                        <div class="p-2 text-center">
                            <a href="#" class="small text-decoration-none fw-bold">See more people</a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection