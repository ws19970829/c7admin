<?php

namespace App\Http\Controllers\Admin;

use App\Models\Services\GradeServices;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;

class GradeController extends BaseController
{
    public function index(Request $request){
      $grade = new GradeServices();
      $data = $grade->getGrade($request,$this->pagesize);
//      dd($data);
        return view('admin.Grade.index',compact('data'));
    }
    public function user($level,Request $request){

        $grade = new GradeServices();
        $data = $grade->name($level,$request);
//        dd($data);
       return view('admin.grade.name',compact('data'));
}
//    public function index()
//    {
//        //
//
//        $data=User::orderBy('vip_level','desc')
//            ->limit(10)
//            ->get(['id','vip_level'])
//            ->groupBy('vip_level');
////        dd($data);
//         $newdata=$data->toArray();
////dump($newdata);
//         foreach($newdata as $k=>$v){
//             $newdata[$k]['id']=null;
//             foreach ($v as $k1=>$v1){
//                 $newdata[$k]=[
//                     'id' => $v1['id'].','.$newdata[$k]['id'],
//                     'sum'=> count($v),
//                 ];
//             }
//
//         }
////        dd($newdata);
//        return view('admin.grade.index',compact('data','newdata'));
//    }


}
