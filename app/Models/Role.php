<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Base
{

    //关联权限，多对多的关系
    public function nodes(){
        return $this->belongsToMany(Node::class,'role_node','role_id','node_id');
    }
}
