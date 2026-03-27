@extends('layouts.master')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4 p-4">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-primary text-uppercase">Create Account</h3>
                <p class="text-muted small">Join our IT Support Portal today</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold small text-secondary">FULL NAME</label>
                    <input type="text" name="name" class="form-control form-control-lg border-2" placeholder="e.g. Abood Asfour" value="{{ old('name') }}" required autofocus>
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-secondary">EMAIL ADDRESS</label>
                    <input type="email" name="email" class="form-control form-control-lg border-2" placeholder="name@example.com" value="{{ old('email') }}" required>
                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                
          <div class="mb-3">
    <label class="form-label fw-bold small text-secondary">PHONE NUMBER</label>
    <input type="text" name="phone" class="form-control form-control-lg border-2" 
           placeholder="e.g. 07XXXXXXXX" value="{{ old('phone') }}" required>
    @error('phone') 
        <span class="text-danger small">{{ $message }}</span> 
    @enderror
</div>

                <div class="mb-4">
                    <label class="form-label fw-bold small text-secondary">PASSWORD</label>
                    <input type="password" name="password" class="form-control form-control-lg border-2" placeholder="••••••••" required>
                    @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small text-secondary">CONFIRM PASSWORD</label>
                    <input type="password" name="password_confirmation" class="form-control form-control-lg border-2" placeholder="••••••••" required>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm py-3">
                        REGISTER NOW
                    </button>
                </div>

                <div class="text-center">
                    <span class="small text-muted">Already have an account?</span>
                    <a href="{{ route('login') }}" class="small fw-bold text-decoration-none ms-1">Login here</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection