<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLogs extends Model
{
    protected $fillable = [
        'store_id',
        'user_id',
        'action',
        'description',
    ];

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
