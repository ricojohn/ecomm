@extends('layouts.app')
@section('title', 'Manage Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><i class="bi bi-box-seam me-2"></i>Products</h3>
    <a href="{{ route('admin.products.create') }}" class="btn btn-dark">
        <i class="bi bi-plus-lg me-1"></i> Add Product
    </a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>SKU</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td><small class="text-muted">{{ $product->sku }}</small></td>
                        <td class="fw-semibold">{{ $product->name }}</td>
                        <td>{{ $product->category }}</td>
                        <td>₱{{ number_format($product->price, 2) }}</td>
                        <td>
                            @if($product->stock > 0)
                                <span class="badge bg-success">{{ $product->stock }}</span>
                            @else
                                <span class="badge bg-danger">0</span>
                            @endif
                        </td>
                        <td>
                            @if($product->availability_status === 'available')
                                <span class="badge bg-success">Available</span>
                            @else
                                <span class="badge bg-secondary">Unavailable</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-dark btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-3">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex justify-content-center mt-3">
    {{ $products->links() }}
</div>
@endsection
