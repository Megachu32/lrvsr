@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold"><i class="fa-solid fa-user-shield text-danger"></i> Admin Dashboard</h2>
            <!-- HACK - checking report page-->
            <a href="{{ route('admin.report') }}" class="btn btn-primary">
                <i class="fa-solid fa-file-lines me-2"></i> View Moderation Report
            </a>
        </div>
        <span class="badge bg-secondary">Logged in as Super Admin</span>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body text-center">
                    <h1 class="display-4 fw-bold">{{ $stats['users'] }}</h1>
                    <div class="text-uppercase small fw-bold">Total Users</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body text-center">
                    <h1 class="display-4 fw-bold">{{ $stats['communities'] }}</h1>
                    <div class="text-uppercase small fw-bold">Communities</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-info text-white">
                <div class="card-body text-center">
                    <h1 class="display-4 fw-bold">{{ $stats['posts'] }}</h1>
                    <div class="text-uppercase small fw-bold">Total Posts</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="fa-solid fa-users me-2"></i> Recent Users
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light small">
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Joined</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>#{{ $user->user_id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $user->avatar_url ?? 'https://via.placeholder.com/30' }}" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                            <span class="fw-bold">{{ $user->username }}</span>
                                        </div>
                                    </td>
                                    <td class="small text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($user->user_id !== Auth::id())
                                            <form action="{{ route('admin.ban', $user->user_id) }}" method="POST" onsubmit="return confirm('Permanently ban this user?')">
                                                @csrf
                                                <button class="btn btn-sm btn-outline-danger" title="Ban User">
                                                    <i class="fa-solid fa-ban"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-success">You</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $users->appends(['communities_page' => $communities->currentPage()])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="fa-solid fa-planet-ringed me-2"></i> Communities
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light small">
                                <tr>
                                    <th>Name</th>
                                    <th>Members</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($communities as $community)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $community->icon_url ?? 'https://via.placeholder.com/30' }}" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                            <div>
                                                <div class="fw-bold">r/{{ $community->name }}</div>
                                                <div class="small text-muted">Created {{ $community->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $community->subscribers_count }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('community.view', $community->community_id) }}" class="btn btn-sm btn-light" title="View">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('community.settings', $community->community_id) }}" class="btn btn-sm btn-light" title="Settings">
                                                <i class="fa-solid fa-gear"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger" title="Delete Community">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $communities->appends(['users_page' => $users->currentPage()])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection