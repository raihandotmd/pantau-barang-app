<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLogs extends Model
{
    //
    public function Store()
    {
        return $this->belongsTo(Stores::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
