<?php

namespace App\Models;

use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'store_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'location',
        'status',
        'total_amount',
    ];

    protected $casts = [
        'location' => Point::class,
    ];

    public function store()
    {
        return $this->belongsTo(Stores::class, 'store_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
