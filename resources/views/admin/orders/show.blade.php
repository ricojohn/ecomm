@extends('layouts.app')
@section('title', 'Order ' . $order->order_number)

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
        <li class="breadcrumb-item active">{{ $order->order_number }}</li>
    </ol>
</nav>

<div class="row">
    <div class="col-lg-8">
        {{-- Order Items --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <span><i class="bi bi-bag me-1"></i> {{ $order->order_number }}</span>
                @php
                    $badgeMap = ['pending'=>'secondary','verified'=>'info','paid'=>'primary','ready_for_pickup'=>'success','cancelled'=>'danger'];
                    $badge = $badgeMap[$order->status] ?? 'secondary';
                @endphp
                <span class="badge bg-{{ $badge }} fs-6">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Line Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td class="fw-semibold">{{ $item->product_name }}</td>
                                <td><small class="text-muted">{{ $item->sku }}</small></td>
                                <td>₱{{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="fw-semibold">₱{{ number_format($item->line_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Total</td>
                            <td class="fw-bold fs-5">₱{{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        {{-- Customer Info --}}
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-person me-1"></i> Customer
            </div>
            <div class="card-body">
                <p class="mb-1 fw-semibold">{{ $order->user->name }}</p>
                <p class="mb-0 text-muted small">{{ $order->user->email }}</p>
            </div>
        </div>

        {{-- Traveler Info --}}
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-secondary text-white">
                <i class="bi bi-person-badge me-1"></i> Traveler Information
            </div>
            <div class="card-body">
                <dl class="row mb-0 small">
                    <dt class="col-sm-5 text-muted">Name</dt>
                    <dd class="col-sm-7">{{ $order->traveler_full_name }}</dd>
                    <dt class="col-sm-5 text-muted">Passport</dt>
                    <dd class="col-sm-7">{{ $order->passport_number }}</dd>
                    <dt class="col-sm-5 text-muted">Nationality</dt>
                    <dd class="col-sm-7">{{ $order->nationality }}</dd>
                    <dt class="col-sm-5 text-muted">Flight</dt>
                    <dd class="col-sm-7">{{ $order->flight_number }}</dd>
                    <dt class="col-sm-5 text-muted">Departure</dt>
                    <dd class="col-sm-7">{{ $order->departure_date->format('d M Y') }}</dd>
                    <dt class="col-sm-5 text-muted">Destination</dt>
                    <dd class="col-sm-7">{{ $order->destination }}</dd>
                </dl>
            </div>
        </div>

        {{-- Eligibility --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <small class="text-muted d-block mb-1">Eligibility Status</small>
                <span class="badge bg-success">{{ ucfirst($order->eligibility_status) }}</span>
                @if($order->eligibility_message)
                    <p class="mt-2 mb-0 small text-muted">{{ $order->eligibility_message }}</p>
                @endif
            </div>
        </div>

        {{-- Update Status --}}
        @if($order->status !== 'cancelled')
        <div class="card shadow-sm mt-3">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-pencil-square me-1"></i> Update Status
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select form-select-sm mb-2">
                        <option value="verified"         {{ $order->status === 'verified'         ? 'selected' : '' }}>Verified</option>
                        <option value="paid"             {{ $order->status === 'paid'             ? 'selected' : '' }}>Paid</option>
                        <option value="ready_for_pickup" {{ $order->status === 'ready_for_pickup' ? 'selected' : '' }}>Ready for Pickup</option>
                    </select>
                    <button type="submit" class="btn btn-dark btn-sm w-100">
                        <i class="bi bi-check2 me-1"></i> Update
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
