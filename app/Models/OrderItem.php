<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'sku',
        'product_name',
        'price',
        'quantity',
        'line_total',
    ];

    protected function casts(): array
    {
        return [
            'price'      => 'decimal:2',
            'line_total' => 'decimal:2',
            'quantity'   => 'integer',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
