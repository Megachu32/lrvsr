@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Community Rules: {{ $community->name }}</h2>
        <button class="btn btn-success" onclick="document.getElementById('add-rule-form').classList.toggle('d-none')">
            + Add New Rule
        </button>
    </div>

    <div id="add-rule-form" class="card mb-4 d-none">
        <div class="card-body">
            <form action="{{ route('rules.store', $community->community_id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Rule Title</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g., Be Respectful" required>
                </div>
                <div class="mb-3">
                    <label>Full Description</label>
                    <textarea name="description" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create Rule</button>
            </form>
        </div>
    </div>

    <hr>

    @foreach($rules as $rule)
    <div class="card mb-2">
        <details class="card-body">
            <summary class="h5 m-0" style="cursor: pointer; list-style: none;">
                <span class="text-primary">▶</span> {{ $rule->title }}
                <small class="text-muted" style="font-size: 0.7em;">(Click to Edit)</small>
            </summary>

            <div class="mt-3 pt-3 border-top">
                <form action="{{ route('rules.update', $rule->rule_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $rule->title }}">
                    </div>

                    <div class="mb-3">
                        <label>Content</label>
                        <textarea name="description" class="form-control" rows="4">{{ $rule->description }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        
                </form>

                <form action="{{ route('rules.destroy', $rule->rule_id) }}" method="POST" onsubmit="return confirm('Delete this rule?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Delete Rule</button>
                </form>
                    </div>
            </div>
        </details>
    </div>
    @endforeach
</div>

<style>
    /* Rotates the arrow when the rule is expanded */
    details[open] summary span {
        display: inline-block;
        transform: rotate(90deg);
    }
    summary { outline: none; }
</style>
@endsection