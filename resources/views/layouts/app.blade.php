<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Reddit Clone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #DAE0E6; } /* Reddit Gray */
        .card { border: none; margin-bottom: 15px; }
        .vote-section { background-color: #F8F9FA; width: 40px; text-align: center; border-right: 1px solid #eee; border-radius: 4px 0 0 4px;}
        .vote-btn { cursor: pointer; color: #878A8C; }
        .vote-btn:hover { color: #CC3700; background-color: #e9e9e9; }
        .subreddit-text { font-weight: bold; font-size: 12px; color: #1C1C1C; }
        .meta-text { font-size: 12px; color: #787C7E; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}" style="font-weight: bold; font-size: 24px; display: flex; align-items: center; gap: 8px;">
                <svg width="100" height="100" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="mainGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#00f2ff;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#7000ff;stop-opacity:1" />
                        </linearGradient>

                        <linearGradient id="darkGradient" x1="0%" y1="100%" x2="100%" y2="0%">
                            <stop offset="0%" style="stop-color:#5a00d1;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#00c8d4;stop-opacity:1" />
                        </linearGradient>

                        <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
                            <feGaussianBlur stdDeviation="2.5" result="coloredBlur" />
                            <feMerge>
                                <feMergeNode in="coloredBlur" />
                                <feMergeNode in="SourceGraphic" />
                            </feMerge>
                        </filter>
                    </defs>

                    <g filter="url(#glow)">

                        <path d="M100 40 L150 65 L100 90 L50 65 Z" fill="url(#mainGradient)" />

                        <path d="M150 65 L150 115 L100 140 L100 90 Z" fill="url(#darkGradient)" />

                        <path d="M50 65 L100 90 L100 140 L50 115 Z" fill="url(#mainGradient)" opacity="0.9" />

                        <path d="M100 90 L100 140" stroke="white" stroke-width="1" stroke-opacity="0.3" />
                        <path d="M100 90 L150 65" stroke="white" stroke-width="1" stroke-opacity="0.3" />
                        <path d="M100 90 L50 65" stroke="white" stroke-width="1" stroke-opacity="0.3" />

                    </g>

                </svg> ClanKer
                
            </a>
            
            <form action="{{ route('search') }}" method="GET" class="d-flex w-50">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fa-solid fa-search text-secondary"></i>
                    </span>
                    <input class="form-control bg-light border-start-0" 
                        type="search" 
                        name="q" 
                        placeholder="Search Reddit..." 
                        value="{{ request('q') }}"> </div>
            </form>

            <div class="navbar-nav ms-auto">
                @auth
                    <a href="{{ route('post.create') }}" class="btn btn-outline-primary me-2 rounded-pill">+ Create Post</a>

                    <a href="{{ route('community.create') }}" class="btn btn-outline-primary me-2 rounded-pill">+ Create Community</a>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout.post') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                            @if(Auth::user()->role_id == 1)
                                <li>
                                    <a class="dropdown-item text-danger fw-bold" href="{{ route('admin.dashboard') }}">
                                        <i class="fa-solid fa-user-shield me-2"></i> Admin Page
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4">Log In</a>                
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>