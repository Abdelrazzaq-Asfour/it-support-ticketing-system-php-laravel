@extends('layouts.master')

@section('content')
<div class="row align-items-center py-5">
    <div class="col-lg-6 mb-5 lg:mb-0">
        <h1 class="display-3 fw-bold text-dark mb-4">
            Professional <span class="text-primary">IT Support</span> System
        </h1>
        <p class="lead text-muted mb-5">
            Welcome to our centralized support portal. We provide a seamless way for employees to report technical issues and for our IT experts to resolve them efficiently.
        </p>

        <div class="d-flex flex-wrap gap-3">
            @guest
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 py-3 shadow-sm fw-bold">
                    GET STARTED NOW
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-dark btn-lg px-5 py-3 fw-bold">
                    LOGIN
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-5 py-3 shadow-sm fw-bold">
                    GO TO DASHBOARD
                </a>
            @endguest
        </div>
    </div>

    <div class="col-lg-6 text-center">
        <div class="p-5 bg-white shadow rounded-circle d-inline-block border border-5 border-primary-subtle">
             <h2 class="text-primary fw-black m-0" style="font-size: 6rem;">IT</h2>
        </div>
        <div class="mt-4">
            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold">
                ● System Online & Ready
            </span>
        </div>
    </div>
</div>

<hr class="my-5 border-2 opacity-10">

<div class="row g-4 text-center">
    <div class="col-md-4">
        <div class="p-4 bg-white rounded-3 shadow-sm border-top border-4 border-primary">
            <h5 class="fw-bold mb-3 text-uppercase">Ticket Tracking</h5>
            <p class="text-muted small mb-0">Submit your technical issues and track their progress from "Pending" to "Resolved" in real-time.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-4 bg-white rounded-3 shadow-sm border-top border-4 border-dark">
            <h5 class="fw-bold mb-3 text-uppercase">Admin Control</h5>
           
            <p class="text-muted small mb-0">Our support engineers have a powerful dashboard to prioritize and manage all incoming requests.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-4 bg-white rounded-3 shadow-sm border-top border-4 border-primary">
            <h5 class="fw-bold mb-3 text-uppercase">Secure Portal</h5>
            <p class="text-muted small mb-0">A secure environment where every employee has a private account to manage their own support history.</p>
        </div>
    </div>
</div>
@endsection