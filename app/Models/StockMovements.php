<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovements extends Model
{
    protected $fillable = [
        'store_id',
        'item_id',
        'quantity_change',
        'type',
        'user_id',
        'notes',
    ];

    protected $casts = [
        'quantity_change' => 'integer',
    ];

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }
    public function item()
    {
        return $this->belongsTo(Items::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
