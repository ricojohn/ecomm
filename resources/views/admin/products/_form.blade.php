<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">SKU <span class="text-danger">*</span></label>
        <input type="text" name="sku"
               class="form-control @error('sku') is-invalid @enderror"
               value="{{ old('sku', $product->sku ?? '') }}" required>
        @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Name <span class="text-danger">*</span></label>
        <input type="text" name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $product->name ?? '') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Category <span class="text-danger">*</span></label>
        <input type="text" name="category"
               class="form-control @error('category') is-invalid @enderror"
               value="{{ old('category', $product->category ?? '') }}" required>
        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label">Price (₱) <span class="text-danger">*</span></label>
        <input type="number" name="price" step="0.01" min="0"
               class="form-control @error('price') is-invalid @enderror"
               value="{{ old('price', $product->price ?? '') }}" required>
        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label">Stock <span class="text-danger">*</span></label>
        <input type="number" name="stock" min="0"
               class="form-control @error('stock') is-invalid @enderror"
               value="{{ old('stock', $product->stock ?? 0) }}" required>
        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Availability Status <span class="text-danger">*</span></label>
        <select name="availability_status" class="form-select @error('availability_status') is-invalid @enderror" required>
            <option value="available" {{ old('availability_status', $product->availability_status ?? '') === 'available' ? 'selected' : '' }}>Available</option>
            <option value="unavailable" {{ old('availability_status', $product->availability_status ?? '') === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
        </select>
        @error('availability_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label class="form-label">Short Description</label>
        <textarea name="short_description" rows="3"
                  class="form-control @error('short_description') is-invalid @enderror"
                  maxlength="500">{{ old('short_description', $product->short_description ?? '') }}</textarea>
        @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
