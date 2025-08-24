@extends('layouts.app')

@section('content')
<div class="container my-4">

    <h2 class="mb-3">Manage Payments for {{ $property->property_name }}</h2>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Payment Form -->
    @if($property->status === 'Available')
        <button class="btn btn-primary mb-3" disabled>Make Payment</button>
        <small class="text-danger d-block mb-3">Property is available</small>
    @else
        <!-- Toggle Button for Mobile -->
        <button class="btn btn-primary mb-3 d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#paymentFormMobile">
            Add Payment
        </button>

        <!-- Desktop Form -->
        <form method="POST" action="{{ route('payments.store') }}" class="row g-3 mb-4 d-none d-md-flex">
            @csrf
            <input type="hidden" name="property_id" value="{{ $property->id }}">
            <div class="col-md-6">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" name="amount" id="amount" step="0.01" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="payment_date" class="form-label">Payment Date</label>
                <input type="date" name="payment_date" id="payment_date" class="form-control" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success">Add Payment</button>
            </div>
        </form>

        <!-- Mobile Form Collapse -->
        <div class="collapse d-md-none mb-4" id="paymentFormMobile">
            <form method="POST" action="{{ route('payments.store') }}">
                @csrf
                <input type="hidden" name="property_id" value="{{ $property->id }}">
                <div class="mb-3">
                    <label for="amount_mobile" class="form-label">Amount</label>
                    <input type="number" name="amount" id="amount_mobile" step="0.01" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="payment_date_mobile" class="form-label">Payment Date</label>
                    <input type="date" name="payment_date" id="payment_date_mobile" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Add Payment</button>
            </form>
        </div>
    @endif

    <hr>

    <!-- Payment History -->
    <h3 class="h6 mb-3">Payment History</h3>

    @if($property->payments->count() > 0)
        <!-- Mobile Cards -->
        <div class="d-md-none">
            @foreach($property->payments->sortByDesc('created_at') as $payment)
                <div class="card mb-2 shadow-sm">
                    <div class="card-body">
                        <p><strong>Payment Added Date:</strong> {{ $payment->created_at }}</p>
                        <p><strong>Date:</strong> {{ $payment->payment_date }}</p>
                        <p><strong>Amount:</strong> ${{ number_format($payment->amount, 2) }}</p>
                        <p><strong>Status:</strong> {{ $payment->status }}</p>
                        <p><strong>Tenant:</strong> {{ $payment->tenant_name }}</p>
                        <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Desktop Table -->
        <div class="table-responsive d-none d-md-block">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Payment Added Date:</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Tenant Name</th>
                        <th>Manage Payment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($property->payments->sortByDesc('created_at') as $payment)
                        <tr>
                            <td>{{ $payment->created_at->timezone('Australia/Sydney')->format('Y-m-d h:i A') }}</td>
                            <td>{{ $payment->payment_date }}</td>
                            <td>${{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->status }}</td>
                            <td>{{ $payment->tenant_name }}</td>
                            <td>
                                <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @else
        <p class="text-muted">No payments yet.</p>
    @endif

    <!-- Back Button -->
    <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3 d-block d-md-none">Back to Properties</a>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3 d-none d-md-inline-block">Back to Properties</a>

</div>
@endsection
