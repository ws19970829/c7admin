<?php

namespace App\Models\Services;
use App\Models\Game;
use App\Models\Spend;
use App\Models\User;
use Illuminate\Http\Request;
use function GuzzleHttp\Psr7\str;


class DownloadServices {
public function time($request){


    $oldtime = Game::orderBy('create_time','asc')->limit(1)->value('create_time');//2017-11-25
//        return $oldtime;
    $newoldtime= strtotime($oldtime);
    $time=date("Y-m-d",strtotime("0 day"));
    $newtime=strtotime($time);
    $length = ($newtime - $newoldtime) /86400;//370
//        return $length;
    $truetime = [];$truetime2=[];
    for ($i=0;$i<= $length;$i++){
        $truetime[] =  date("Y-m-d",strtotime( date("Y-m-d",strtotime("- $i day"))));
    }
//        return $truetime;
    for ($i=0;$i<= $length;$i++){
        $truetime2[] =  strtotime(date("Y-m-d",strtotime("- $i day"))) ;
    }
    $st = strtotime($request->get('st'));
    $et = strtotime($request->get('et'));
//    $st = strtotime($request->st);
//    $et = strtotime($request->et);
//    dump($st);
//    dump($et);
// dump($truetime2);
    if(empty($st)){
        return $truetime2;
    }else{
        if(!in_array($st,$truetime2)){
            return $truetime2;
        }else{
            $k1=0;$k2=0;
           $length = ($et-$st)/86400;
           foreach ($truetime2 as $k=>$v){
               if($v==$st){
                   $k1=$k;
               }else if($v==$et){
                   $k2 = $k;
               }
           }
//           dump($k1.','.$k2);
           $truetime2=[];
            for ($i=$k2;$i<=$k1;$i++){
                $truetime2[]=strtotime( date("Y-m-d",strtotime("- $i day")));
            }
            return $truetime2;
        }
    }

}

    public function getData(Request $request,int $pagesize=10,int $offset=0){
        $truetime2 =$this->time($request);
//        return $truetime2;
        $data=[];
        $j = $offset;
        $jj =$pagesize+$offset;
        if(count($truetime2)<=$pagesize){
            $jj=count($truetime2);
        }

//        return [$j,$jj];
        for ($i=$j;$i<$jj;$i++){

            $beginToday=strtotime(date('Y-m-d 00:00:00',$truetime2[$i]));
//            return $beginToday;
            $endToday=strtotime(date('Y-m-d 23:59:59',$truetime2[$i]));

            $time = [$beginToday,$endToday];
//        return $time;
//      $time=1577980800;
            $st = $request->get('st');
            $et = $request->get('et');
            //安卓新增充值
            $game =Game::when($st,function ($query)use($st,$et,$time){
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('create_time',[$st,$et]);
            })->whereBetween('create_time',[$beginToday,$endToday])
                ->select('id','dow_num','game_name')
                ->orderBy('create_time','desc')
                ->paginate($pagesize);
             $sum = $game->count();
            $arr=$game->toArray();
            $data[] = [
                'time'=> date('Y-m-d',$beginToday),
                'sum'=>$sum,
                'game'=>$arr['data'],
            ];

        }
//        return $game;
        return $data;

    }

















//    //苹果新增充值
//    public function getIosData(Request $request,int $pagesize=10,int $sdk_version=2){
//        //php获取今日开始时间戳和结束时间戳
//        $beginToday=mktime(0,0,0,date('m'),date('d')-2,date('Y'));
//        $endToday=mktime(0,0,0,date('m'),date('d')-1,date('Y'))-1;
//        $time = [$beginToday,$endToday];
////    $time=1577980800;
//        $st = $request->get('st');
//        $et = $request->get('et');
//        $data=Spend::when($st,function ($query)use($st,$et,$time){
//            $st=date('Y-m-d 00:00:00',strtotime($st));
//            $et=date('Y-m-d 23:59:59',strtotime($et));
//            $query->whereBetween('pay_time',$time);
//        })->whereBetween('pay_time',[$beginToday,$endToday])->where('sdk_version',$sdk_version)->orderBy('pay_time','desc')->select('pay_time','pay_amount')->paginate($pagesize);
////          return $data;
//        return $data->sum('pay_amount');
//    }
//
//    public function data(Request $request,int $pagesize=10){
//        return [
//            'And_new_pay'=> $this->getAndData($request,$pagesize),
//            'Ios_new_pay'=> $this->getIosData($request,$pagesize),
//        ];
//
//
//    }

}
