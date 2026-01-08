@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        @foreach($posts as $post)
        <div class="card d-flex flex-row overflow-hidden">
            <div class="vote-section p-2 d-flex flex-column align-items-center justify-content-center">
                <button class="btn btn-sm btn-link vote-btn" data-id="{{ $post->id }}" data-val="1">
                    <i class="fas fa-arrow-up text-secondary"></i>
                </button>
                
                <span class="fw-bold" id="score-{{ $post->id }}">{{ $post->score() }}</span>
                
                <button class="btn btn-sm btn-link vote-btn" data-id="{{ $post->id }}" data-val="-1">
                    <i class="fas fa-arrow-down text-secondary"></i>
                </button>
            </div>

            <div class="card-body">
                <small class="text-muted">
                    Posted by {{ $post->user->name }} in <strong>{{ $post->category->name }}</strong> 
                    • {{ $post->created_at->diffForHumans() }}
                </small>
                <h5 class="card-title mt-1">{{ $post->title }}</h5>
                <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                
                <div>
                    @foreach($post->tags as $tag)
                        <span class="badge rounded-pill" style="background-color: {{ $tag->color }}">{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
    // [AJAX Implementation]
    $(document).ready(function() {
        $('.vote-btn').click(function() {
            var postId = $(this).data('id');
            var voteValue = $(this).data('val');
            var btn = $(this);

            $.ajax({
                url: "/vote/" + postId,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    value: voteValue
                },
                success: function(response) {
                    // Update score number
                    $('#score-' + postId).text(response.new_score);
                    
                    // Optional: Visual Feedback (Change color)
                    if(voteValue == 1) {
                        btn.find('i').removeClass('text-secondary').addClass('text-danger');
                        btn.siblings('.vote-btn').find('i').addClass('text-secondary').removeClass('text-primary');
                    } else {
                        btn.find('i').removeClass('text-secondary').addClass('text-primary');
                        btn.siblings('.vote-btn').find('i').addClass('text-secondary').removeClass('text-danger');
                    }
                },
                error: function(xhr) {
                    if(xhr.status === 401) {
                        alert('Please login to vote!');
                        window.location.href = "{{ route('login') }}";
                    }
                }
            });
        });
    });
</script>
@endpush