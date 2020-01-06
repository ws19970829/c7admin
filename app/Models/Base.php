<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//软删除
use Illuminate\Database\Eloquent\SoftDeletes;

class Base extends Model
{

    use SoftDeletes;
    //指定软删除字段
    protected  $dates = ['deleted_at'];
    //黑名单
    protected $guarded=[];

}
