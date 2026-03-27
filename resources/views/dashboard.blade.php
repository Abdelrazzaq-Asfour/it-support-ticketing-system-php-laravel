@extends('layouts.master')

@section('content')
<div class="row text-center py-5">
    <div class="col-md-12">
        <div class="card shadow-lg border-0 p-5 bg-white rounded-4">
            <h1 class="display-4 fw-bold text-dark mb-3">Support Portal</h1>
            <p class="lead text-muted mb-5">Welcome back! Manage your technical issues with ease.</p>
            
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('tickets.index') }}" class="btn btn-primary btn-lg px-5 py-3 shadow-sm fw-bold text-uppercase">
                    View My Tickets
                </a>
                <a href="{{ route('tickets.create') }}" class="btn btn-outline-dark btn-lg px-5 py-3 fw-bold text-uppercase">
                    + Open New Ticket
                </a>
            </div>
        </div>
    </div>
</div>
@endsection