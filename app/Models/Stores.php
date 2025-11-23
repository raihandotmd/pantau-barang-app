<?php

namespace App\Models;

use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'contact_info',
        'address',
        'location_latlong',
        'location',
        'description',
    ];

    protected $casts = [
        'location_latlong' => 'array',
        'location' => Point::class,
    ];

    /**
     * Get the users that belong to this store.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'store_id');
    }
}
