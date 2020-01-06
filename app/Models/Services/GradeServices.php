<?php

namespace App\Models\Services;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class GradeServices
{

    public function getGrade(Request $request,int $pagesize=10){
          $data=User::select(['vip_level',DB::raw('count(*) as num')])
              ->groupBy('vip_level')
              ->orderBy('vip_level','desc')
              ->paginate($pagesize);
          return $data;
    }

    public function name($level,Request $request){
 $data = User::where('vip_level',$level)->get(['real_name','account']);
 return $data;
    }

}
