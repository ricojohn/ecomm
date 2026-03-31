<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'subtotal',
        'total',
        'checkout_token',
        'traveler_full_name',
        'passport_number',
        'nationality',
        'flight_number',
        'departure_date',
        'destination',
        'eligibility_status',
        'eligibility_message',
    ];

    protected function casts(): array
    {
        return [
            'departure_date' => 'date',
            'subtotal'       => 'decimal:2',
            'total'          => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
