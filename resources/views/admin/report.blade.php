@extends('layouts.app')

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Moderation Report</h3>
        <button onclick="window.print()" class="btn btn-secondary btn-sm">Print PDF</button>
    </div>

    <form action="{{ route('admin.report') }}" method="GET" class="row g-3 mb-4 bg-light p-3 border rounded">
        <div class="col-auto">
            <label class="col-form-label">Filter Date:</label>
        </div>
        <div class="col-auto">
            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Apply Filter</button>
        </div>
    </form>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Votes</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->user->name }}</td>
                <td><span class="badge bg-info">{{ $post->category->name }}</span></td>
                <td>{{ $post->score() }}</td>
                <td>{{ $post->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No data found for this filter.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection