<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DutyFree Shop')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }
        #toast-container { position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 9999; min-width: 280px; }
        .product-card { transition: transform .15s; }
        .product-card:hover { transform: translateY(-3px); }
    </style>
    @stack('styles')
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('products.index') }}">
            <i class="bi bi-airplane-fill me-1"></i> DutyFree
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                </li>
                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.products.index') }}">Manage Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.orders.index') }}">Manage Orders</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">My Orders</a>
                        </li>
                    @endif
                @endauth
            </ul>
            <ul class="navbar-nav ms-auto align-items-center">
                @auth
                    {{-- @if(! auth()->user()->isAdmin()) --}}
                        <li class="nav-item me-2">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="bi bi-cart3"></i>
                                <span class="badge bg-warning text-dark" id="cart-count">
                                    {{ auth()->user()->cart?->items->count() ?? 0 }}
                                </span>
                            </a>
                        </li>
                    {{-- @endif --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-warning btn-sm ms-2" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

{{-- Flash messages --}}
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

{{-- Page content --}}
<main class="container my-4">
    @yield('content')
</main>

{{-- Bootstrap toast container (AJAX notifications) --}}
<div id="toast-container"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    function showToast(message, type) {
        type = type || 'success';
        var id = 'toast-' + Date.now();
        var html = '<div id="' + id + '" class="toast align-items-center text-bg-' + type + ' border-0 mb-2" role="alert" aria-live="assertive">' +
            '<div class="d-flex">' +
            '<div class="toast-body">' + message + '</div>' +
            '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>' +
            '</div></div>';
        $('#toast-container').append(html);
        var toastEl = document.getElementById(id);
        var toast = new bootstrap.Toast(toastEl, { delay: 3500 });
        toast.show();
        toastEl.addEventListener('hidden.bs.toast', function () { $(this).remove(); });
    }

    // AJAX Add to Cart
    $(document).on('click', '.btn-add-to-cart', function (e) {
        e.preventDefault();
        var btn       = $(this);
        var productId = btn.data('id');
        var quantity  = btn.data('quantity') || 1;

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                product_id: productId,
                quantity: quantity,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                showToast(res.message, res.success ? 'success' : 'danger');
                if (res.success) {
                    $('#cart-count').text(res.cart_count);
                }
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    showToast('Please log in to add items to your cart.', 'warning');
                } else {
                    showToast('Something went wrong. Please try again.', 'danger');
                }
            },
            complete: function () {
                btn.prop('disabled', false).html('<i class="bi bi-cart-plus"></i> Add to Cart');
            }
        });
    });

    // Initialize Filter Categories
    $(document).on('click', '.btn-filter-category', function (e) {
        e.preventDefault();
        var category = $(this).data('category');
        $('.btn-filter-category').removeClass('active');
        $(this).addClass('active');
        $('.category-container').hide();
        if (category === 'all') {
            $('.category-container').show();
            $('.category-container.active').removeClass('active');
        } else {
            $('#category-container-' + category).show();
            $('.category-container.active').removeClass('active');
            $('#category-container-' + category).addClass('active');
        }
    });
    
    // Initialize Search items
    $(document).on('input', '#search-input', function (e) {
        e.preventDefault();
        var search = $(this).val();
        
        var categoryContainers = $('.category-container');
        var categoryItems = categoryContainers.find('.card-title');
        var activeCategory = $('.btn-filter-category.active');

        if (search === '') {
            if(activeCategory.data('category') === 'all' || activeCategory.data('category') === undefined) {
                categoryContainers.show();
                categoryContainers.each(function () {
                    $(this).find('.col').each(function () {
                        $(this).show();
                    });
                });
                
            } else {
                categoryContainers.hide();
                $('#category-container-' + activeCategory.data('category')).show();
                $('#category-container-' + activeCategory.data('category')).find('.col').each(function () {
                    $(this).show();
                });
            }
        } else {
            if(activeCategory.data('category') === 'all' || activeCategory.data('category') === undefined) {
                categoryContainers.show();
                categoryContainers.each(function () {
                    $(this).find('.col').each(function () {
                        if ($(this).find('.card-title').text().toLowerCase().includes(search.toLowerCase())) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                });
            }else{
                categoryContainers.hide();
                $('#category-container-' + activeCategory.data('category')).show();
                $('#category-container-' + activeCategory.data('category')).find('.col').each(function () {
                    if ($(this).find('.card-title').text().toLowerCase().includes(search.toLowerCase())) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
            
        }
    });
</script>
@stack('scripts')
</body>
</html>
