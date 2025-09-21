<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovements extends Model
{
    //
    public function Store()
    {
        return $this->belongsTo(Stores::class);
    }
    public function Item()
    {
        return $this->belongsTo(Items::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
