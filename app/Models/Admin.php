<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
//软删除
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use SoftDeletes;
    //指定软删除字段
    protected  $dates = ['deleted_at'];
    //黑名单
    protected $guarded=[];

    //修改器
    public function setPassWordAttribute( $value)
    {
        $this->attributes['password']=bcrypt($value);
    }
    //角色 关联
    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }

}
