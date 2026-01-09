@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manage r/{{ $community->name }}</h2>

{{-- 1. OWNER SETTINGS (Icon) --}}
    {{-- USE NEW LOGIC: Allow Community Admin OR Global Admin --}}
    @if(($mySubscription && $mySubscription->role === 'admin') || Auth::user()->role_id == 1)
    
    {{-- USE MAIN STYLING: It looks better --}}
    <div class="card mb-4 border-primary">
        <div class="card-header bg-primary text-white">Owner Settings</div>
        <div class="card-body">
            
            <form action="{{ route('community.updateIcon', $community->community_id) }}" method="POST"> 
                @csrf
                {{-- USE NEW LOGIC: Method Spoofing is required --}}
                @method('PUT')

                <label class="fw-bold">Community Icon URL</label>
                
                {{-- USE MAIN INPUT: It has the 'input-group' layout and validation --}}
                <div class="input-group mt-2">
                    <input type="url" name="icon_url" value="{{ $community->icon_url }}" class="form-control" placeholder="https://..." required>
                    <button type="submit" class="btn btn-primary">Save Icon</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- 2. MEMBER MANAGEMENT --}}
    <div class="card">
        <div class="card-header">Member Roles</div>
        <div class="card-body">
            <table class="table align-middle">
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
                        <td>
                            <img src="{{ $member->user->avatar_url ?? 'https://via.placeholder.com/30' }}" class="rounded-circle me-1" width="30">
                            {{ $member->user->username }}
                        </td>
                        <td>
                            @if($member->role === 'admin') <span class="badge bg-danger">Owner</span>
                            @elseif($member->role === 'moderator') <span class="badge bg-success">Mod</span>
                            @else <span class="badge bg-secondary">Member</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $canEdit = false;
                                // Admin can edit anyone except themselves (obviously)
                                if ($mySubscription->role === 'admin' && $member->role !== 'admin') $canEdit = true;
                                // Mods can only edit regular members
                                if ($mySubscription->role === 'moderator' && $member->role === 'member') $canEdit = true;
                            @endphp

                            @if($canEdit)
                            <div class="d-flex gap-2">
                                {{-- Standard Role Change Form --}}
                                <form action="{{ route('community.updateRole', $community->community_id) }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $member->user_id }}">
                                    
                                    <select name="role" class="form-select form-select-sm w-auto">
                                        <option value="member" {{ $member->role == 'member' ? 'selected' : '' }}>Member</option>
                                        <option value="moderator" {{ $member->role == 'moderator' ? 'selected' : '' }}>Moderator</option>
                                    </select>
                                    
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Save</button>
                                    <button type="submit" name="ban" value="1" class="btn btn-sm btn-danger" onclick="return confirm('Ban this user from the community?')">Ban</button>
                                </form>

                                {{-- NEW: Transfer Ownership Button (Only for Owner) --}}
                                @if($mySubscription->role === 'admin')
                                <form action="{{ route('community.transfer', $community->community_id) }}" method="POST" onsubmit="return confirm('DANGER: Are you sure you want to transfer ownership to {{ $member->user->username }}? You will lose Owner status.')">
                                    @csrf
                                    <input type="hidden" name="new_owner_id" value="{{ $member->user_id }}">
                                    <button type="submit" class="btn btn-sm btn-warning" title="Make Owner">
                                        <i class="fa-solid fa-crown"></i> Pass Crown
                                    </button>
                                </form>
                                @endif
                            </div>
                            @else
                                @if($member->user_id === Auth::id())
                                    <span class="badge bg-light text-dark border">It's You</span>
                                @else
                                    <span class="text-muted small">No actions</span>
                                @endif
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