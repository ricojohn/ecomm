@extends('layouts.app')
@section('title', 'Your Cart')

@section('content')
<h3 class="mb-4"><i class="bi bi-cart3 me-2"></i>Your Cart</h3>

@if(! $cart || $cart->items->isEmpty())
    <div class="alert alert-info">
        Your cart is empty. <a href="{{ route('products.index') }}">Browse products</a>
    </div>
@else
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
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
                                    <td>
                                        <form method="POST" action="{{ route('cart.update', $item) }}" class="d-flex gap-1">
                                            @csrf @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                   min="1" max="{{ $item->product->stock }}"
                                                   class="form-control form-control-sm" style="width:65px">
                                            <button type="submit" class="btn btn-outline-success btn-sm">
                                                Update
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                        </form>
                                        @error('quantity')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td class="fw-semibold">₱{{ number_format($item->line_total, 2) }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('cart.remove', $item) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Remove this item?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span>₱{{ number_format($cart->subtotal, 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span>₱{{ number_format($cart->total, 2) }}</span>
                    </div>
                    <div class="d-grid mt-3">
                        <a href="{{ route('checkout.traveler') }}" class="btn btn-dark">
                            <i class="bi bi-airplane me-1"></i> Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
