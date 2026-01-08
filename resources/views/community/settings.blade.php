@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manage r/{{ $community->name }}</h2>

    @if($mySubscription->role === 'admin')
    <div class="card mb-4">
        <div class="card-header">Owner Settings</div>
        <div class="card-body">
            <form action="#" method="POST"> @csrf
                <label>Community Icon URL</label>
                <input type="text" name="icon_url" value="{{ $community->icon_url }}" class="form-control mb-2">
                <button class="btn btn-primary">Save Icon</button>
            </form>
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-header">Member Roles</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Current Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($members as $member)
                    <tr>
                        <td>{{ $member->user->username }}</td>
                        <td>
                            @if($member->role === 'admin') <span class="badge bg-danger">Owner</span>
                            @elseif($member->role === 'moderator') <span class="badge bg-success">Mod</span>
                            @else <span class="badge bg-secondary">Member</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $canEdit = false;
                                if ($mySubscription->role === 'admin' && $member->role !== 'admin') $canEdit = true;
                                if ($mySubscription->role === 'moderator' && $member->role === 'member') $canEdit = true;
                            @endphp

                            @if($canEdit)
                            <form action="{{ route('community.updateRole', $community->community_id) }}" method="POST" class="d-flex gap-2">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $member->user_id }}">
                                
                                <select name="role" class="form-select form-select-sm w-auto">
                                    <option value="member" {{ $member->role == 'member' ? 'selected' : '' }}>Member</option>
                                    <option value="moderator" {{ $member->role == 'moderator' ? 'selected' : '' }}>Moderator</option>
                                    @if($mySubscription->role === 'admin')
                                        @endif
                                </select>
                                
                                <button type="submit" class="btn btn-sm btn-outline-primary">Save</button>
                                <button type="submit" name="ban" value="1" class="btn btn-sm btn-danger">Ban</button>
                            </form>
                            @else
                                <span class="text-muted small">No actions available</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection