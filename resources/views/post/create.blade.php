@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Create a Post</h4>
                <a href="{{ route('community.create') }}" class="btn btn-sm btn-outline-secondary">Create New Community</a>
            </div>
            
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('post.create.post') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Choose a Community</label>
                        <select name="community_id" class="form-select" required>
                            <option value="" disabled selected>Select a community (r/...)</option>
                            @foreach($communities as $community)
                                <option value="{{ $community->community_id }}">r/{{ $community->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="An interesting title" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Body</label>
                        <textarea name="content" class="form-control" rows="6" placeholder="Text (optional)"></textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-2 rounded-pill">Cancel</a>
                        <button type="submit" class="btn btn-dark rounded-pill px-4">Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection