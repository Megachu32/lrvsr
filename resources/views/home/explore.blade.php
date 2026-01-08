@extends('layouts.app')

@section('content')
<div class="container">

    <div class="mb-5">
        <h5 class="fw-bold mb-3">Trending Communities</h5>
        <div class="row">

        @foreach($communities as $community)
            <div class="col-md-3 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="bg-primary rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px; font-size: 24px;">
                            <img src="{{ $community->icon_url }}" 
                                class="rounded-circle border" 
                                style="width: 60px; height: 60px; object-fit: cover;" 
                                alt="Avatar">                        
                        </div>
                        <h6 class="fw-bold mb-0">r/{{ $community->name }}</h6>
                        <small class="text-secondary">{{ $community->subscribers_count }} Members</small>
                        <a href="{{ route('community.join', $community->community_id) }}"  class="btn btn-outline-primary rounded-pill btn-sm w-100 mt-2 fw-bold">Join</a>

                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>    
</div>
@endsection