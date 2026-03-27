@extends('layouts.master')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="fw-bold text-dark mb-4 text-uppercase"><i class="bi bi-person-gear"></i> Account Settings</h3>

            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold">Personal Information</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf @method('PATCH')
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">FULL NAME</label>
                            <input type="text" name="name" class="form-control border-2" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">EMAIL ADDRESS</label>
                            <input type="email" name="email" class="form-control border-2" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">PHONE NUMBER</label>
                            <input type="text" name="phone" class="form-control border-2" value="{{ old('phone', $user->phone) }}">
                        </div>

                        <button type="submit" class="btn btn-primary fw-bold px-4 shadow-sm">SAVE CHANGES</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold">Update Password</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf @method('PUT')

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">CURRENT PASSWORD</label>
                            <input type="password" name="current_password" class="form-control border-2" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">NEW PASSWORD</label>
                            <input type="password" name="password" class="form-control border-2" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">CONFIRM NEW PASSWORD</label>
                            <input type="password" name="password_confirmation" class="form-control border-2" required>
                        </div>

                        <button type="submit" class="btn btn-dark fw-bold px-4 shadow-sm">UPDATE PASSWORD</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection