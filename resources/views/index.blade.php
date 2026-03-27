@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-secondary text-uppercase">{{ auth()->user()->is_admin ? 'Admin Dashboard' : 'My Support History' }}</h3>
        </div>

        <div class="card shadow-sm p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Ticket ID</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Date Created</th>
                            @if(auth()->user()->is_admin) <th>Manage Status</th> @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                        <tr>
                            <td class="fw-bold text-primary">#{{ $ticket->id }}</td>
                            <td>{{ $ticket->title }}</td>
                            <td>
                                @if($ticket->status == 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-2">PENDING</span>
                                @else
                                    <span class="badge bg-success px-3 py-2">RESOLVED</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $ticket->created_at->format('M d, Y') }}</td>
                            @if(auth()->user()->is_admin)
                            <td>
                                <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="d-flex gap-2">
                                    @csrf @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                        <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    </select>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No tickets found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection