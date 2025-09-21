<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    //
    public function Store()
    {
        return $this->belongsTo(Stores::class, 'store_id');
    }
}
