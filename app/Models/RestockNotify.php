<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestockNotify extends Model
{
    protected $fillable = [
        'store_id',
        'item_id',
        'contact_info',
        'notified_at',
    ];

    protected $casts = [
        'notified_at' => 'datetime',
    ];

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }

    public function item()
    {
        return $this->belongsTo(Items::class);
    }
}
