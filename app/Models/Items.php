<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    //
    public function Store()
    {
        return $this->belongsTo(Stores::class, 'store_id');
    }
    public function Category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
