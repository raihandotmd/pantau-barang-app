<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    protected $casts = [
        'location_latlong' => 'array',
    ];
    //
}
