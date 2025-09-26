<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'contact_info',
        'address',
        'location_latlong',
        'description',
    ];

    protected $casts = [
        'location_latlong' => 'array',
    ];

    /**
     * Get the users that belong to this store.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'store_id');
    }
}
