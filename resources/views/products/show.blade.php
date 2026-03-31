@extends('layouts.app')
@section('title', $product->name)

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
        <li class="breadcrumb-item active">{{ $product->name }}</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h3 class="card-title mb-1">{{ $product->name }}</h3>
                        <p class="text-muted mb-0 small">SKU: {{ $product->sku }}</p>
                    </div>
                    <span class="badge bg-secondary fs-6">{{ $product->category }}</span>
                </div>

                <hr>

                @if($product->short_description)
                    <p class="card-text text-muted">{{ $product->short_description }}</p>
                @endif

                <div class="d-flex align-items-center justify-content-between my-3">
                    <span class="fs-3 fw-bold">₱{{ number_format($product->price, 2) }}</span>
                    @if($product->availability_status === 'available' && $product->stock > 0)
                        <span class="badge bg-success fs-6">
                            <i class="bi bi-check-circle me-1"></i> In Stock &mdash; {{ $product->stock }} available
                        </span>
                    @else
                        <span class="badge bg-secondary fs-6">Unavailable</span>
                    @endif
                </div>

                @if($product->isAvailable())
                    <div class="d-grid mt-3">
                        <button class="btn btn-dark btn-lg btn-add-to-cart" data-id="{{ $product->id }}">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                @else
                    <div class="alert alert-warning mt-3 mb-0">This product is currently out of stock.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
