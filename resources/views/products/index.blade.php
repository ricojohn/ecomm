@extends('layouts.app')
@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><i class="bi bi-grid me-2"></i>Duty-Free Products</h3>
</div>
    <button class="btn btn-outline-dark btn-sm btn-filter-category" data-category="all">All</button>
@foreach($products->groupBy('category') as $category => $items)
    <button class="btn btn-outline-dark btn-sm btn-filter-category" data-category="{{ $category }}">{{ $category }}</button>
@endforeach

<div class="row mt-4">
    <div class="col-lg-3">
        <input type="text" class="form-control" id="search-input" placeholder="Search products" autocomplete="off">
    </div>
</div>

@if($products->isEmpty())
    <div class="alert alert-info">No products available at the moment.</div>
@else
    {{-- Group by category --}}
    <div id="categories-container">
        @foreach($products->groupBy('category') as $category => $items)
        <div class="category-container" id="category-container-{{ $category }}">
            <h5 class="text-muted text-uppercase fw-semibold mt-4 mb-3 border-bottom pb-1">
                <i class="bi bi-tag me-1"></i> {{ $category }}
            </h5>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-4">
                @foreach($items as $product)
                    <div class="col">
                        <div class="card h-100 product-card shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ $product->name }}</h6>
                                <p class="text-muted small mb-2">{{ $product->sku }}</p>
                                @if($product->short_description)
                                    <p class="card-text small text-muted flex-grow-1">{{ Str::limit($product->short_description, 80) }}</p>
                                @endif
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-bold text-dark fs-5">₱{{ number_format($product->price, 2) }}</span>
                                        @if($product->availability_status === 'available' && $product->stock > 0)
                                            <span class="badge bg-success">In Stock ({{ $product->stock }})</span>
                                        @else
                                            <span class="badge bg-secondary">Unavailable</span>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-dark btn-sm flex-grow-1">
                                            View
                                        </a>
                                        @if($product->isAvailable())
                                            <button class="btn btn-dark btn-sm flex-grow-1 btn-add-to-cart"
                                                    data-id="{{ $product->id }}">
                                                <i class="bi bi-cart-plus"></i> Add to Cart
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

@endif
@endsection
