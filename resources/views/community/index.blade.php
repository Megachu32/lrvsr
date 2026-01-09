@extends('layouts.app')

@section('content')
<div class="card border-0 mb-3">
    <div class="bg-primary" style="height: 100px; border-radius: 4px 4px 0 0;"></div>
    
    <div class="card-body d-flex align-items-end pb-2" style="margin-top: -30px;">
        <div class="bg-white rounded-circle p-1">
            <div class="bg-dark rounded-circle d-flex align-items-center justify-content-center text-white border border-4 border-white" style="width: 70px; height: 70px; font-size: 30px;">
                <img src="{{ !empty($community->icon_url) ? $community->icon_url : 'https://via.placeholder.com/70' }}" 
                    class="rounded-circle border" 
                    style="width: 70px; height: 70px; object-fit: cover;" 
                    alt="Avatar">
            </div>
        </div>
        
        <div class="ms-3 mb-1 d-flex justify-content-between w-100 align-items-end">
            <div>
                <h3 class="fw-bold mb-0">r/{{ $community->name ?? 'topic' }}</h3>
                <div class="text-secondary small">r/{{ $community->name ?? 'topic' }}</div>
            </div>
            <a href="{{ route('community.join', $community->community_id) }}" class="btn btn-primary rounded-pill px-4 fw-bold">Join</a>
        </div>
    </div>
</div>

<a href="{{ route('community.settings', $community->community_id) }}" class="btn btn-primary rounded-pill px-4 fw-bold">Temp</a>


<div class="row">
    <div class="col-md-8">

        @foreach($posts as $post)
            <div class="card d-flex flex-row mb-3"> 
                
                <div class="vote-section d-flex flex-column align-items-center p-2 bg-light">
                    
                    {{-- UPVOTE BUTTON (No Form) --}}
                    <button onclick="ajaxVote({{ $post->post_id }}, 1)" 
                            class="border-0 bg-transparent p-0">
                        <i id="up-btn-{{ $post->post_id }}" 
                           class="fa-solid fa-arrow-up vote-btn mb-1 {{ $post->user_vote_type == 1 ? 'text-warning' : 'text-secondary' }}"></i>
                    </button>

                    {{-- SCORE --}}
                    <span id="score-{{ $post->post_id }}" class="fw-bold my-1">
                        {{ $post->votes_sum_vote_type ?? 0 }}
                    </span>

                    {{-- DOWNVOTE BUTTON (No Form) --}}
                    <button onclick="ajaxVote({{ $post->post_id }}, -1)" 
                            class="border-0 bg-transparent p-0">
                        <i id="down-btn-{{ $post->post_id }}" 
                           class="fa-solid fa-arrow-down vote-btn mt-1 {{ $post->user_vote_type == -1 ? 'text-primary' : 'text-secondary' }}"></i>
                    </button>

                </div>
                
                <div class="p-2 w-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="mb-1">
                            <span class="subreddit-text fw-bold">r/{{ $post->community->name ?? 'unknown' }}</span>
                            <span class="meta-text ms-2">• Posted by u/{{ $post->user->username }} {{ $post->created_at->diffForHumans() }}</span>
                        </div>
                        @php
                            // Check if the logged-in user is a mod/admin of THIS community
                            $userRole = 'guest';
                            if(Auth::check()) {
                                $sub = \App\Models\Subscription::where('user_id', Auth::id())
                                            ->where('community_id', $post->community_id)
                                            ->first();
                                if($sub) $userRole = $sub->role;
                            }
                        @endphp

                        @if(Auth::id() === $post->user_id || $userRole === 'admin' || $userRole === 'moderator')
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">...</button>
                                <ul class="dropdown-menu">
                                    
                                    @if(Auth::id() === $post->user_id)
                                        <li><a href="{{ route('post.edit', $post->post_id) }}" class="dropdown-item">Edit</a></li>
                                    @endif

                                    <li>
                                        <form action="{{ route('post.destroy', $post->post_id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="dropdown-item text-danger">Delete Post</button>
                                        </form>
                                    </li>
                                    
                                </ul>
                            </div>
                        @endif
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
                                {{-- Loop through Parent Comments --}}
                                @foreach($post->comments as $comment)
                                    <div class="mb-3 border-bottom pb-2">
                                        <div class="d-flex justify-content-between">
                                            <strong class="small">{{ $comment->user->username }}</strong>
                                            <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mb-1 small">{{ $comment->content }}</p>

                                        {{-- Child Comments (Replies) --}}
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

                                {{-- "View All" Link if there are more comments than the 3 we loaded --}}
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

    <div class="col-md-4 d-none d-md-block">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white fw-bold">About Community</div>
            <div class="card-body">
                <p class="card-text">{{ $community->description ?? 'No description available.' }}</p>
                
                <div class="d-flex mb-3">
                    <div class="me-4">
                        <div class="fw-bold">{{ $community->subscribers_count ?? 0 }}</div>
                        <div class="text-secondary small">Members</div>
                    </div>
                </div>

                <hr>
                <div class="mb-3">
                    <div class="small text-secondary"><i class="fa-solid fa-cake-candles"></i> Created At {{ $community->created_at->format('M d, Y') }}</div>
                </div>

                <a href="{{ route('post.create') }}" class="btn btn-primary w-100 rounded-pill mb-2">Create Post</a>
            </div>
        </div>

        {{-- TODO make a rule page --}}
        <div class="card">
            <div class="card-header bg-light fw-bold small">
                r/{{ $community->name ?? 'topic' }} Rules 
                @if(Auth::check() && Auth::user()->user_id == $community->creator_id)
                <form action="{{ route('rules.view', $community->community_id) }}" method="POST" class="d-inline-block float-end">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm w-30 rounded-pill mb-2">Edit</button>
                </form>
                @endif
            </div>
            
            <!-- <ol class="list-group list-group-numbered list-group-flush small">
            @foreach($community->rules as $rule)
                <li class="list-group-item">{{ $rule->title }}</li>
            @endforeach
            </ol> -->

            <ul class="list-group list-group-flush small">
                @foreach($community->rules as $rule)
                    <li class="list-group-item"> {{-- p-0 removes padding so the clickable area fills the whole row --}}
                        <details class="w-100">
                            <summary class="d-flex justify-content-between align-items-center p-2" style="cursor: pointer; list-style: none;">
                                <strong>{{ $rule->title }}</strong>
                                <span class="text-muted small">▼</span>
                            </summary>
                            
                            <div class="p-1 border-top bg-light">
                                {{ $rule->description }}
                            </div>
                        </details>
                    </li>
                @endforeach
            </ul>

    <style>
        /* This removes the default small arrow so we can use our own */
        summary::-webkit-details-marker {
            display: none;
        }

        /* Rotates the arrow when the dropdown is open */
        details[open] summary span {
            transform: rotate(180deg);
        }

        /* Optional: adds a nice hover effect */
        summary:hover {
            background-color: #f8f9fa;
        }
    </style>

            
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