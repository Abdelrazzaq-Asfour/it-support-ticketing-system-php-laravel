@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark text-uppercase">
                <i class="bi bi-people-fill"></i> Staff & User Management
            </h3>
            <span class="badge bg-primary px-3 py-2 shadow-sm">Total Users: {{ $users->count() }}</span>
        </div>

        <div class="card shadow-sm border-0 bg-white rounded-3 p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="p-3">Full Name</th>
                            <th class="p-3">Contact Details</th> <th class="p-3 text-center">Current Role</th>
                            <th class="p-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-bottom">
                            <td class="p-3 fw-bold text-dark">
                                <div class="d-flex align-items-center">
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 30px; height: 30px; font-size: 12px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    {{ $user->name }}
                                </div>
                            </td>
                            
                            <td class="p-3">
                                <div class="fw-bold text-primary small">
                                    <i class="bi bi-telephone-fill me-1"></i> {{ $user->phone ?? 'N/A' }}
                                </div>
                                <div class="text-muted small">
                                    <i class="bi bi-envelope-fill me-1"></i> {{ $user->email }}
                                </div>
                            </td>

                            <td class="p-3 text-center">
                                @if($user->is_admin)
                                    <span class="badge bg-dark text-white px-3 py-2 rounded-pill shadow-sm">
                                        <i class="bi bi-shield-lock"></i> ADMIN
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                        REGULAR USER
                                    </span>
                                @endif
                            </td>
                            <td class="p-3 text-end">
                                <form action="{{ route('staff.toggle', $user->id) }}" method="POST">
                                    @csrf 
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="btn btn-sm {{ $user->is_admin ? 'btn-outline-danger' : 'btn-outline-primary' }} fw-bold px-3 shadow-sm"
                                            {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                        {{ $user->is_admin ? 'Revoke Admin' : 'Promote to Admin' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection