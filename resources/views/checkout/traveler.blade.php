@extends('layouts.app')
@section('title', 'Traveler Information')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="card-title mb-1">
                    <i class="bi bi-person-badge me-2"></i>Traveler Information
                </h4>
                <p class="text-muted small mb-4">Please provide your travel details to verify your eligibility for duty-free purchase.</p>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('checkout.verify') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="full_name"
                               class="form-control @error('full_name') is-invalid @enderror"
                               value="{{ old('full_name') }}" required>
                        @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Passport Number <span class="text-danger">*</span></label>
                            <input type="text" name="passport_number"
                                   class="form-control @error('passport_number') is-invalid @enderror"
                                   value="{{ old('passport_number') }}" required>
                            @error('passport_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nationality <span class="text-danger">*</span></label>
                            <input type="text" name="nationality"
                                   class="form-control @error('nationality') is-invalid @enderror"
                                   value="{{ old('nationality') }}" required>
                            @error('nationality')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row g-3 mt-0">
                        <div class="col-md-6">
                            <label class="form-label">
                                Flight Number <span class="text-danger">*</span>
                                <small class="text-muted">(e.g. AB123)</small>
                            </label>
                            <input type="text" name="flight_number"
                                   class="form-control @error('flight_number') is-invalid @enderror"
                                   value="{{ old('flight_number') }}" placeholder="AB123" required>
                            @error('flight_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Departure Date <span class="text-danger">*</span></label>
                            <input type="date" name="departure_date"
                                   class="form-control @error('departure_date') is-invalid @enderror"
                                   value="{{ old('departure_date') }}"
                                   min="{{ date('Y-m-d') }}" required>
                            @error('departure_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label class="form-label">Destination <span class="text-danger">*</span></label>
                        <input type="text" name="destination"
                               class="form-control @error('destination') is-invalid @enderror"
                               value="{{ old('destination') }}" required>
                        @error('destination')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back to Cart
                        </a>
                        <button type="submit" class="btn btn-dark flex-grow-1">
                            <i class="bi bi-shield-check me-1"></i> Verify & Continue
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
