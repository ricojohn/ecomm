@extends('layouts.app')
@section('title', 'All Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><i class="bi bi-list-check me-2"></i>All Orders</h3>
    <span class="badge bg-secondary fs-6">{{ $orders->total() }} total</span>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Flight</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    @php
                        $badgeMap = ['pending'=>'secondary','verified'=>'info','paid'=>'primary','ready_for_pickup'=>'success','cancelled'=>'danger'];
                        $badge = $badgeMap[$order->status] ?? 'secondary';
                    @endphp
                    <tr>
                        <td class="fw-semibold">{{ $order->order_number }}</td>
                        <td>
                            <div>{{ $order->user->name }}</div>
                            <small class="text-muted">{{ $order->user->email }}</small>
                        </td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>{{ $order->flight_number }}</td>
                        <td><span class="badge bg-{{ $badge }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span></td>
                        <td class="fw-semibold">₱{{ number_format($order->total, 2) }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-dark btn-sm">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-3">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex justify-content-center mt-3">
    {{ $orders->links() }}
</div>
@endsection
