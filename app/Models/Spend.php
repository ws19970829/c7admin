<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spend extends Model
{
    //
    public function getPayTimeAttribute()
    {
        return date('Y-m-d',$this->attributes['pay_time']);
    }

}
