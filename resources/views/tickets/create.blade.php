@extends('layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow p-4">
            <h4 class="fw-bold mb-4 text-primary">Open a New Support Ticket</h4>
            <hr>
            <form action="{{ route('tickets.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-semibold">Issue Subject</label>
                    <input type="text" name="title" class="form-control form-control-lg border-2" placeholder="Briefly describe the issue" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Detailed Description</label>
                    <textarea name="description" rows="5" class="form-control border-2" placeholder="Tell us more about the problem..." required></textarea>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold shadow">SUBMIT TICKET</button>
                    <a href="{{ route('tickets.index') }}" class="btn btn-link text-secondary mt-2">Back to Dashboard</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection