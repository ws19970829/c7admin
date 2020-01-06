<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    public function getLoginTimeAttribute()
    {
        return date('Y-m-d',$this->attributes['login_time']);
    }
    public function getRegisterTimeAttribute()
    {
        return date('Y-m-d',$this->attributes['register_time']);
    }

    public function userLoginRecords(){
        return $this->hasMany(UserLoginRecords::class,'user_id');
    }
}
