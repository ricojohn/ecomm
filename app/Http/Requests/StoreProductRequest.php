<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'sku'                 => ['required', 'string', 'max:100', 'unique:products,sku,' . $productId],
            'name'                => ['required', 'string', 'max:255'],
            'category'            => ['required', 'string', 'max:100'],
            'price'               => ['required', 'numeric', 'min:0'],
            'stock'               => ['required', 'integer', 'min:0'],
            'availability_status' => ['required', 'in:available,unavailable'],
            'short_description'   => ['nullable', 'string', 'max:500'],
        ];
    }
}
