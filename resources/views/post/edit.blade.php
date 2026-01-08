@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Post</h2>
    <form action="{{ route('post.update', $post->post_id) }}" method="POST">
        @csrf
        @method('PUT') <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $post->title }}">
        </div>

        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" class="form-control" rows="5">{{ $post->content }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection