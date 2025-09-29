<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = [
        'name',
        'store_id',
    ];

    public function store()
    {
        return $this->belongsTo(Stores::class, 'store_id');
    }

    public function items()
    {
        return $this->hasMany(Items::class, 'category_id');
    }
}
