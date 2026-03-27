@extends('layouts.master')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark"><i class="bi bi-speedometer2 text-primary"></i> Super Admin Control Center</h2>
        <span class="badge bg-dark px-3 py-2 shadow-sm">Real-time Stats: {{ now()->format('M d, Y') }}</span>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white p-3 h-100">
                <div class="card-body">
                    <h6 class="text-uppercase small fw-bold opacity-75">Global Tickets</h6>
                    <h2 class="fw-bold mb-0">{{ $totalTickets }}</h2>
                    <i class="bi bi-ticket-detailed fs-1 opacity-25 float-end"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-warning text-dark p-3 h-100">
                <div class="card-body">
                    <h6 class="text-uppercase small fw-bold opacity-75">Needs Action</h6>
                    <h2 class="fw-bold mb-0">{{ $pendingTickets }}</h2>
                    <i class="bi bi-clock-history fs-1 opacity-25 float-end"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white p-3 h-100">
                <div class="card-body">
                    <h6 class="text-uppercase small fw-bold opacity-75">Solved Today</h6>
                    <h2 class="fw-bold mb-0">{{ $resolvedToday }}</h2>
                    <i class="bi bi-check-all fs-1 opacity-25 float-end"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-dark text-white p-3 h-100">
                <div class="card-body">
                    <h6 class="text-uppercase small fw-bold text-warning">⭐ System Hero</h6>
                    @if($topAdmin && $topAdmin->solved_tickets_count > 0)
                        <div class="mt-2 fw-bold small">{{ $topAdmin->name }}</div>
                        <div class="text-warning" style="font-size: 11px;">{{ $topAdmin->solved_tickets_count }} Cases Solved</div>
                    @else
                        <div class="small mt-2 opacity-50">Calculating...</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 fw-bold"><i class="bi bi-activity"></i> Recent System Activity</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="p-3">User</th>
                        <th class="p-3">Subject</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTickets as $ticket)
                    <tr>
                        <td class="p-3 fw-bold">{{ $ticket->user->name }}</td>
                        <td class="p-3">{{ $ticket->title }}</td>
                        <td class="p-3">
                            <span class="badge {{ $ticket->status == 'pending' ? 'bg-warning text-dark' : 'bg-success' }} rounded-pill px-3">
                                {{ strtoupper($ticket->status) }}
                            </span>
                        </td>
                        <td class="p-3"><a href="{{ route('tickets.index') }}" class="btn btn-sm btn-outline-dark fw-bold">Manage</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection