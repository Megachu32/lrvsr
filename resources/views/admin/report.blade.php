@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h4 class="mb-0"><i class="fa-solid fa-chart-line text-primary"></i> User Activity Matrix</h4>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.report') }}" method="GET" id="reportForm" class="row g-3 mb-4 bg-light p-3 rounded border">
            
            <div class="col-md-3">
                <label class="form-label fw-bold">Community</label>
                <select name="community_id" class="form-select" onchange="document.getElementById('reportForm').submit()">
                    <option value="" disabled {{ request('community_id') ? '' : 'selected' }}>Select Community...</option>
                    @foreach($allCommunities as $comm)
                        <option value="{{ $comm->community_id }}" {{ request('community_id') == $comm->community_id ? 'selected' : '' }}>
                            r/{{ $comm->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-9">
                <label class="form-label fw-bold">Quick Select Duration</label>
                <div class="btn-group w-100 mb-2" role="group">
                    <button type="button" class="btn btn-outline-secondary" onclick="setDateRange(3)">Last 3 Days</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="setDateRange(7)">Last 7 Days</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="setDateRange(30)">Last 30 Days</button>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $start->format('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $end->format('Y-m-d') }}">
            </div>

            <div class="col-md-4 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1"><i class="fa-solid fa-filter"></i> Filter</button>
                
                @if($community_id)
                {{-- Only show download if a community is selected --}}
                <button type="submit" name="export" value="true" class="btn btn-success">
                    <i class="fa-solid fa-file-excel"></i> Export Excel
                </button>
                @endif
            </div>
        </form>

        @if($community_id)
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-start">User / Date</th>
                            @foreach($dates as $date)
                                <th>{{ \Carbon\Carbon::parse($date)->format('M d') }}</th>
                            @endforeach
                            <th class="bg-secondary">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($matrix as $username => $days)
                            @php $rowTotal = 0; @endphp
                            <tr>
                                <td class="text-start fw-bold">{{ $username }}</td>
                                @foreach($dates as $date)
                                    @php 
                                        $count = $days[$date] ?? 0; 
                                        $rowTotal += $count;
                                        // Highlight High Activity Cells
                                        $bgClass = $count > 0 ? 'bg-success-subtle' : ''; 
                                        $textClass = $count > 0 ? 'text-success fw-bold' : 'text-muted';
                                    @endphp
                                    <td class="{{ $bgClass }}">
                                        <span class="{{ $textClass }}">{{ $count > 0 ? $count : '-' }}</span>
                                    </td>
                                @endforeach
                                <td class="fw-bold bg-light">{{ $rowTotal }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($dates) + 2 }}" class="py-4 text-muted">
                                    No activity found in this community for this date range.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fa-solid fa-arrow-up"></i> Please select a <strong>Community</strong> above to view the report.
            </div>
        @endif
    </div>
</div>

<script>
    function setDateRange(days) {
        const end = new Date();
        const start = new Date();
        start.setDate(end.getDate() - (days - 1)); // -1 to include today

        // Format to YYYY-MM-DD for HTML input
        document.getElementById('end_date').value = end.toISOString().split('T')[0];
        document.getElementById('start_date').value = start.toISOString().split('T')[0];
        
        // Auto submit for "reactive" feel
        document.getElementById('reportForm').submit();
    }
</script>
@endsection