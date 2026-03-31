@extends('layouts.app')
@section('title', 'Edit Product')

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
        <li class="breadcrumb-item active">Edit: {{ $product->name }}</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="card-title mb-4"><i class="bi bi-pencil-square me-2"></i>Edit Product</h4>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.products.update', $product) }}">
                    @csrf @method('PUT')
                    @include('admin.products._form')
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-dark flex-grow-1">
                            <i class="bi bi-check2 me-1"></i> Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
