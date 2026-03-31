@extends('layouts.app')
@section('title', 'My Orders')

@section('content')
<h3 class="mb-4"><i class="bi bi-receipt me-2"></i>My Orders</h3>

@if($orders->isEmpty())
    <div class="alert alert-info">
        You have no orders yet. <a href="{{ route('products.index') }}">Start shopping</a>
    </div>
@else
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Flight</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td class="fw-semibold">{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>
                                @php
                    $badgeMap = [
                        'pending'          => 'secondary',
                        'verified'         => 'info',
                        'paid'             => 'primary',
                        'ready_for_pickup' => 'success',
                        'cancelled'        => 'danger',
                    ];
                                    $badge = $badgeMap[$order->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                            </td>
                            <td>{{ $order->flight_number }}</td>
                            <td class="fw-semibold">₱{{ number_format($order->total, 2) }}</td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-dark btn-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-3">
        {{ $orders->links() }}
    </div>
@endif
@endsection
