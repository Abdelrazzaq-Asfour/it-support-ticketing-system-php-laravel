@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-12">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark text-uppercase">
                <i class="bi bi-ticket-perforated"></i> 
                {{ auth()->user()->is_admin || auth()->user()->email === 'aboodasfour@gmail.com' ? 'Global Ticket Explorer' : 'My Support History' }}
            </h3>
            <a href="{{ route('tickets.create') }}" class="btn btn-primary px-4 fw-bold shadow-sm">+ OPEN NEW TICKET</a>
        </div>

        <div class="card shadow-sm border-0 mb-4 bg-white rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('tickets.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Search Term</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-start-0 shadow-none" 
                                   placeholder="ID, Subject, User..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-muted text-uppercase">Status</label>
                        <select name="status_filter" class="form-select bg-light shadow-none">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status_filter') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="resolved" {{ request('status_filter') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-muted text-uppercase">Ticket Origin</label>
                        <select name="origin" class="form-select bg-light shadow-none">
                            <option value="">All Origins</option>
                            <option value="internal" {{ request('origin') == 'internal' ? 'selected' : '' }}>Internal (Admin)</option>
                            <option value="staff" {{ request('origin') == 'staff' ? 'selected' : '' }}>Staff Members</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Date Range</label>
                        <div class="d-flex gap-1">
                            <input type="date" name="date_from" class="form-control bg-light shadow-none p-1 small" value="{{ request('date_from') }}">
                            <input type="date" name="date_to" class="form-control bg-light shadow-none p-1 small" value="{{ request('date_to') }}">
                        </div>
                    </div>

                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-dark w-100 fw-bold shadow-sm">FILTER</button>
                        <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary w-100 fw-bold">RESET</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 bg-white rounded-3 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="p-3">ID</th>
                            <th class="p-3">USER & CONTACT</th> 
                            <th class="p-3" style="width: 35%;">ISSUE SUBJECT</th>
                            <th class="p-3 text-center">STATUS</th>
                            <th class="p-3">DATE CREATED</th>
                            @if(auth()->user()->is_admin || auth()->user()->email === 'aboodasfour@gmail.com' || $tickets->contains('user_id', auth()->id()))
                                <th class="p-3 text-center">ACTION</th> 
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                        <tr class="border-bottom {{ $ticket->user->is_admin ? 'bg-light-subtle' : '' }}">
                            <td class="p-3 fw-bold text-primary">#{{ $ticket->id }}</td>
                            
                            <td class="p-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold shadow-sm" style="width: 35px; height: 35px; font-size: 13px;">
                                        {{ strtoupper(substr($ticket->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $ticket->user->name }}</div>
                                        <div class="text-muted small">
                                            <i class="bi bi-telephone text-primary" style="font-size: 11px;"></i> {{ $ticket->user->phone ?? 'N/A' }}
                                        </div>
                                        
                                        @if($ticket->user->email === 'aboodasfour@gmail.com')
                                            <span class="badge bg-warning text-dark p-1 mt-1 shadow-sm" style="font-size: 8px; width: fit-content;">
                                                <i class="bi bi-star-fill"></i> SUPERVISOR TASK
                                            </span>
                                        @elseif($ticket->user->is_admin)
                                            <span class="badge bg-dark text-white p-1 mt-1 shadow-sm" style="font-size: 8px; width: fit-content;">
                                                <i class="bi bi-shield-check"></i> ADMIN TASK
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="fw-bold text-dark">{{ $ticket->title }}</div>
                                    <button class="btn btn-sm btn-link text-decoration-none fw-bold p-0 text-primary" 
                                            type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#details{{ $ticket->id }}">
                                        Details ↓
                                    </button>
                                </div>
                                
                                <div class="collapse mt-2" id="details{{ $ticket->id }}">
                                    <div class="p-3 bg-white shadow-sm border rounded-3 small text-start">
                                        <div class="mb-3 border-bottom pb-2">
                                            <strong class="text-uppercase text-muted" style="font-size: 10px;">Original Description:</strong>
                                            <p class="mb-0 text-dark">{{ $ticket->description }}</p>
                                        </div>

                                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-clock-history"></i> Ticket Timeline</h6>
                                        
                                        <div class="mb-3" style="max-height: 250px; overflow-y: auto;">
                                            @forelse($ticket->comments as $comment)
                                                <div class="mb-3 p-2 border-start border-3 {{ $comment->user->is_admin || $comment->user->email === 'aboodasfour@gmail.com' ? 'border-dark bg-light' : 'border-primary' }} rounded-end">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <span class="fw-bold text-dark">{{ $comment->user->name }}</span>
                                                        <small class="text-muted" style="font-size: 10px;">{{ $comment->created_at->diffForHumans() }}</small>
                                                    </div>
                                                    <p class="mb-0 text-secondary">{{ $comment->comment }}</p>
                                                </div>
                                            @empty
                                                <div class="text-center py-2 text-muted fst-italic">No updates on this ticket yet.</div>
                                            @endforelse
                                        </div>

                                        <form action="{{ route('tickets.comment', $ticket->id) }}" method="POST" class="mt-3 border-top pt-3">
                                            @csrf
                                            <div class="input-group shadow-sm">
                                                <input type="text" name="comment" class="form-control form-control-sm border-2 shadow-none" placeholder="Write a quick update..." required>
                                                <button class="btn btn-primary btn-sm fw-bold" type="submit">REPLY</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>

                            <td class="p-3 text-center">
                                @if($ticket->status == 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm"><i class="bi bi-clock"></i> PENDING</span>
                                @else
                                    <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm"><i class="bi bi-check2-circle"></i> RESOLVED</span>
                                @endif
                            </td>

                            <td class="p-3 text-muted small text-nowrap">
                                <i class="bi bi-calendar3"></i> {{ $ticket->created_at->format('M d, Y') }}
                            </td>

                            <td class="p-3 text-center">
                                @if(auth()->user()->is_admin || auth()->user()->email === 'aboodasfour@gmail.com' || auth()->id() === $ticket->user_id)
                                    <button class="btn btn-sm btn-outline-primary fw-bold px-3 shadow-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#updateModal{{ $ticket->id }}">
                                        UPDATE
                                    </button>

                                    <div class="modal fade text-start" id="updateModal{{ $ticket->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content shadow-lg border-0">
                                                <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title fw-bold">Action on Ticket #{{ $ticket->id }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold small text-muted text-uppercase">Change Status</label>
                                                            <select name="status" class="form-select border-2">
                                                                <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Pending (Not Fixed/Re-open)</option>
                                                                <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved (Fixed)</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold small text-muted text-uppercase">Reason / Solution Details</label>
                                                            <textarea name="note" class="form-control border-2" rows="4" placeholder="Explain why you are changing the status..." required></textarea>
                                                            <small class="text-info mt-1"><i class="bi bi-info-circle"></i> This note will be added to the Timeline.</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">CLOSE</button>
                                                        <button type="submit" class="btn btn-primary fw-bold">SAVE & LOG ACTION</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted">No results found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection