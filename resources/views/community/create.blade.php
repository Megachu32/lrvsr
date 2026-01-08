@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0">Create a Community</h4>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name</label>
                        <div class="input-group">
                            <span class="input-group-text">r/</span>
                            <input type="text" name="name" class="form-control" placeholder="gaming" required>
                        </div>
                        <small class="text-muted">No spaces, keep it short.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="What is this community about?"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-pill px-4 w-100">Create Community</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection