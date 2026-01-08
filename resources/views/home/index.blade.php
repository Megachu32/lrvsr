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
                    <a href="{{ route('post.create') }}" class="nav-link text-secondary">
                        <i class="fa-solid fa-plus me-2"></i> Create Post
                    </a>
                    <a href="{{ route('community.create') }}" class="nav-link text-secondary">
                        <i class="fa-solid fa-plus me-2"></i> Create Community
                    </a>
                    
                    <hr class="my-2 text-secondary">

                    <p class="text-uppercase text-secondary fw-bold small px-3 mb-1" style="font-size: 11px;">Communities</p>

                    @foreach($communities as $community)
                        <a href="{{ route('community.view', $community->community_id) }}" class="nav-link text-secondary d-flex justify-content-between align-items-center">
                            <span>
                                <img src="{{ !empty($community->icon_url) ? $community->icon_url : 'https://via.placeholder.com/30' }}" 
                                    class="rounded-circle border" 
                                    style="width: 30px; height: 30px; object-fit: cover;" 
                                    alt="Avatar">                        
                                <i class="fa-solid me-2"></i> r/{{ $community->name }}
                            </span>
                        </a>
                    @endforeach

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

        @foreach($posts as $post)
            <div class="card d-flex flex-row mb-3"> 
                
                {{-- VOTE SECTION (FIXED FOR AJAX) --}}
                <div class="vote-section d-flex flex-column align-items-center p-2 bg-light">
                    
                    {{-- Upvote Button --}}
                    <button onclick="ajaxVote({{ $post->post_id }}, 1)" 
                            class="border-0 bg-transparent p-0">
                        <i id="up-btn-{{ $post->post_id }}" 
                           class="fa-solid fa-arrow-up vote-btn mb-1 {{ $post->user_vote_type == 1 ? 'text-warning' : 'text-secondary' }}"></i>
                    </button>

                    {{-- Score --}}
                    <span id="score-{{ $post->post_id }}" class="fw-bold my-1">
                        {{ $post->votes_sum_vote_type ?? 0 }}
                    </span>

                    {{-- Downvote Button --}}
                    <button onclick="ajaxVote({{ $post->post_id }}, -1)" 
                            class="border-0 bg-transparent p-0">
                        <i id="down-btn-{{ $post->post_id }}" 
                           class="fa-solid fa-arrow-down vote-btn mt-1 {{ $post->user_vote_type == -1 ? 'text-primary' : 'text-secondary' }}"></i>
                    </button>

                </div>
                
                <div class="p-2 w-100">
                    <div class="mb-1">
                        <span class="subreddit-text fw-bold">r/{{ $post->community->name ?? 'unknown' }}</span>
                        <span class="meta-text ms-2">• Posted by u/{{ $post->user->username }} {{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <h5 class="card-title fw-bold">{{ $post->title }}</h5>
                    <p class="card-text">{{ $post->content }}</p>

                    <div class="d-flex gap-3 mt-2">
                        <button class="btn btn-light btn-sm text-secondary fw-bold" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapseComments-{{ $post->id }}" 
                                aria-expanded="false">
                            <i class="fa-regular fa-comment-alt"></i> {{ $post->comments_count ?? 0 }} Comments
                        </button>
                    </div>

                    <div class="collapse mt-3" id="collapseComments-{{ $post->id }}">
                        <div class="card card-body bg-light border-0">
                            
                            @if($post->comments->count() > 0)
                                @foreach($post->comments as $comment)
                                    <div class="mb-3 border-bottom pb-2">
                                        <div class="d-flex justify-content-between">
                                            <strong class="small">{{ $comment->user->username }}</strong>
                                            <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mb-1 small">{{ $comment->content }}</p>

                                        {{-- Child Comments --}}
                                        <div class="ms-4 mt-2 border-start ps-3 border-primary">
                                            @foreach($comment->replies->take(2) as $reply)
                                                <div class="mb-2">
                                                    <strong class="small text-secondary">{{ $reply->user->username }}</strong>
                                                    <p class="mb-0 small text-muted">{{ $reply->content }}</p>
                                                </div>
                                            @endforeach
                                            
                                            @if($comment->replies->count() > 2)
                                                <a href="#" class="small text-primary text-decoration-none">View more replies...</a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                                @if($post->comments_count > 3)
                                    <div class="text-center">
                                        <a href="#" class="btn btn-sm btn-outline-dark rounded-pill">View all {{ $post->comments_count }} comments</a>
                                    </div>
                                @endif
                            @else
                                <p class="text-muted small mb-0">No comments yet. Be the first!</p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <div class="col-md-3 d-none d-lg-block">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white fw-bold">About Community</div>
            {{-- Note: This currently loops ALL communities. Adjust if you only want to see stats for one. --}}
            @foreach($communities as $community)
                <a href="{{ route('community.view', $community->community_id) }}" class="nav-link text-secondary d-flex justify-content-between align-items-center" style="padding: 10px 15px;">
                    <span>
                        <img src="{{ !empty($community->icon_url) ? $community->icon_url : 'https://via.placeholder.com/30' }}" 
                            class="rounded-circle border" 
                            style="width: 30px; height: 30px; object-fit: cover;" 
                            alt="Avatar">    
                        <i class="fa-solid me-2"></i> r/{{ $community->name }}
                    </span>
                </a>
            @endforeach
            <a href="{{ route('explore') }}" class="nav-link text-secondary d-flex justify-content-between align-items-center" style="padding: 10px 15px;">
                <span><i class="fa-solid me-2"></i> Create Community</span>
            </a>
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

{{-- JAVASCRIPT FOR AJAX VOTING --}}
<script>
    async function ajaxVote(postId, type) {
        const url = "{{ route('post.vote') }}"; 
        
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    post_id: postId,
                    vote_type: type
                })
            });

            const data = await response.json();

            if (data.success) {
                // Update Score
                document.getElementById('score-' + postId).innerText = data.new_total;

                // Update Colors
                const upIcon = document.getElementById('up-btn-' + postId);
                const downIcon = document.getElementById('down-btn-' + postId);

                // Reset
                upIcon.className = 'fa-solid fa-arrow-up vote-btn mb-1 text-secondary';
                downIcon.className = 'fa-solid fa-arrow-down vote-btn mt-1 text-secondary';

                // Set new color
                if (data.user_status === 1) {
                    upIcon.classList.remove('text-secondary');
                    upIcon.classList.add('text-warning');
                } else if (data.user_status === -1) {
                    downIcon.classList.remove('text-secondary');
                    downIcon.classList.add('text-primary');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            // Optional: alert('Vote failed. Login required?');
        }
    }
</script>
@endsection