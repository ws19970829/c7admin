<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //
    public function getCreateTimeAttribute()
    {
        return date('Y-m-d',$this->attributes['create_time']);
    }
}
