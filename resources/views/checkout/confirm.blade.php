@extends('layouts.app')
@section('title', 'Confirm Order')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <h4 class="mb-4"><i class="bi bi-clipboard-check me-2"></i>Order Confirmation</h4>

        {{-- Traveler Info --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-person-badge me-1"></i> Traveler Information
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-sm-6">
                        <small class="text-muted">Full Name</small>
                        <div class="fw-semibold">{{ $traveler['full_name'] }}</div>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted">Passport Number</small>
                        <div class="fw-semibold">{{ $traveler['passport_number'] }}</div>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted">Nationality</small>
                        <div class="fw-semibold">{{ $traveler['nationality'] }}</div>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted">Flight Number</small>
                        <div class="fw-semibold">{{ $traveler['flight_number'] }}</div>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted">Departure Date</small>
                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($traveler['departure_date'])->format('d M Y') }}</div>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted">Destination</small>
                        <div class="fw-semibold">{{ $traveler['destination'] }}</div>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-success fs-6">
                        <i class="bi bi-shield-check me-1"></i> Traveler Verified
                    </span>
                </div>
            </div>
        </div>

        {{-- Order Items --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-bag me-1"></i> Order Items
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart->items as $item)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $item->product->name }}</div>
                                    <small class="text-muted">{{ $item->product->sku }}</small>
                                </td>
                                <td>₱{{ number_format($item->product->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="fw-semibold">₱{{ number_format($item->line_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total</td>
                            <td class="fw-bold fs-5">₱{{ number_format($cart->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('checkout.traveler') }}" class="btn btn-outline-secondary">
                <i class="bi bi-pencil me-1"></i> Edit Traveler Info
            </a>
            <form method="POST" action="{{ route('checkout.place') }}" class="flex-grow-1">
                @csrf
                <button type="submit" class="btn btn-success w-100 btn-lg">
                    <i class="bi bi-check2-circle me-1"></i> Place Order
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
