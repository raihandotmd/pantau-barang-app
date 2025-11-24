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

    protected $appends = [
        'latitude',
        'longitude',
    ];

    public function getLatitudeAttribute()
    {
        return $this->location ? $this->location->getLatitude() : null;
    }

    public function getLongitudeAttribute()
    {
        return $this->location ? $this->location->getLongitude() : null;
    }

    public function store()
    {
        return $this->belongsTo(Stores::class, 'store_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
