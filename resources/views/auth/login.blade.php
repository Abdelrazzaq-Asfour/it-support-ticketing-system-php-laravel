@extends('layouts.master')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4 p-4">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-primary text-uppercase">Welcome Back</h3>
                <p class="text-muted small">Login to access your support portal</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold small text-secondary">EMAIL ADDRESS</label>
                    <input type="email" name="email" class="form-control form-control-lg border-2" required autofocus>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold small text-secondary">PASSWORD</label>
                    <input type="password" name="password" class="form-control form-control-lg border-2" required>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm py-3">LOGIN</button>
                </div>
                <div class="text-center small">
                    <a href="{{ route('register') }}" class="fw-bold text-decoration-none">Create an account</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection