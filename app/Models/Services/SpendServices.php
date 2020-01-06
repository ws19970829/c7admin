<?php

namespace App\Models\Services;
use App\Models\Spend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Psr7\str;


class SpendServices {
public static $time = [];

public function time($request){


    $oldtime = User::orderBy('register_time','asc')->limit(1)->value('register_time');
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
        if($j+$jj>=count($truetime2)){
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
            $And_new_pay=Spend::when($st,function ($query)use($st,$et,$time){
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('pay_time',[$st,$et]);
            })->whereBetween('pay_time',[$beginToday,$endToday])->where('sdk_version',1)->orderBy('pay_time','desc')->select('pay_time','pay_amount')->paginate($pagesize);
            $And_new_pay= $And_new_pay->sum('pay_amount');
            //安卓老用户充值
            $And_old_pay=Spend::when($st,function ($query)use($st,$et,$time,$beginToday){
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('pay_time',[$st,$et]);
            })->where('pay_time','<',$beginToday)->where('sdk_version',1)->orderBy('pay_time','desc')->select('pay_time','pay_amount')->paginate($pagesize);
            $And_old_pay= $And_old_pay->sum('pay_amount');
//        return $And_old_pay;


            //苹果新增充值
            $Ios_new_pay=Spend::when($st,function ($query)use($st,$et,$time){
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('pay_time',[$st,$et]);
            })->whereBetween('pay_time',[$beginToday,$endToday])->where('sdk_version',2)->orderBy('pay_time','desc')->select('pay_time','pay_amount')->paginate($pagesize);
//          return $data;
            $Ios_new_pay=$Ios_new_pay->sum('pay_amount');

            //苹果老用户充值
            $Ios_old_pay=Spend::when($st,function ($query)use($st,$et,$time,$beginToday){
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('pay_time',[$st,$et]);
            })->where('pay_time','<',$beginToday)->where('sdk_version',2)->orderBy('pay_time','desc')->select('pay_time','pay_amount')->paginate($pagesize);
            $Ios_old_pay= $Ios_old_pay->sum('pay_amount');

            $sum_pay = $And_new_pay+$And_old_pay+$Ios_new_pay+$Ios_old_pay;


            //苹果活跃值
            $null=null;
            $Ios_new_active=User::when($st,function ($query)use($st,$et,$time){
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('login_time',[$st,$et]);
            })->whereBetween('login_time',[$beginToday,$endToday])
                ->where('unique_id',$null)
                ->select('login_time','id')
//                ->select([DB::raw('count(*) as num')])
//                ->groupBy('login_time')
                ->orderBy('login_time','desc')
                ->paginate($pagesize);
//          return $data;
                 $Ios_new_active = $Ios_new_active->count();
            //苹果老活跃度
            $Ios_old_active=User::when($st,function ($query)use($st,$et,$time){
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('login_time',[$st,$et]);
            })->where('login_time','<',$beginToday)
                ->where('unique_id',$null)
                ->select('login_time','id')
//                ->select([DB::raw('count(*) as num')])
//                ->groupBy('login_time')
                ->orderBy('login_time','desc')
                ->paginate($pagesize);
//          return $data;
            $Ios_old_active = $Ios_old_active->count();

                 //安卓活跃值
            $And_new_active=User::when($st,function ($query)use($st,$et,$time){
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('login_time',[$st,$et]);
            })->whereBetween('login_time',[$beginToday,$endToday])
                ->where('unique_id','!=',$null)
                ->select('login_time','id')
//                ->select([DB::raw('count(*) as num')])
//                ->groupBy('login_time')
                ->orderBy('login_time','desc')
                ->paginate($pagesize);
//          return $data;
            $And_new_active = $And_new_active->count();
            //安卓老活跃度
            $And_old_active=User::when($st,function ($query)use($st,$et,$time){
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('login_time',[$st,$et]);
            })->where('login_time','<',$beginToday)
                ->where('unique_id','!=',$null)
                ->select('login_time','id')
//                ->select([DB::raw('count(*) as num')])
//                ->groupBy('login_time')
                ->orderBy('login_time','desc')
                ->paginate($pagesize);
//          return $data;
            $And_old_active = $And_old_active->count();

            $sum_active = $Ios_new_active+$Ios_old_active+$And_new_active+$And_old_active;


            //苹果新注册
            $Ios_new_reg=User::when($st,function ($query)use($st,$et,$time){
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('register_time',[$st,$et]);
            })->whereBetween('register_time',[$beginToday,$endToday])
                ->where('unique_id',$null)
                ->select('register_time','id')
//                ->select([DB::raw('count(*) as num')])
//                ->groupBy('login_time')
                ->orderBy('register_time','desc')
                ->paginate($pagesize);
//          return $data;
            $Ios_new_reg = $Ios_new_reg->count();
            //苹果老注册
            $Ios_old_reg=User::when($st,function ($query)use($st,$et,$time){
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('register_time',[$st,$et]);
            })->where('register_time','<',$beginToday)
                ->where('unique_id',$null)
                ->select('register_time','id')
//                ->select([DB::raw('count(*) as num')])
//                ->groupBy('login_time')
                ->orderBy('register_time','desc')
                ->paginate($pagesize);
//          return $data;
            $Ios_old_reg = $Ios_old_reg->count();

            //安卓注册值
            $And_new_reg=User::when($st,function ($query)use($st,$et,$time){
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('register_time',[$st,$et]);
            })->whereBetween('register_time',[$beginToday,$endToday])
                ->where('unique_id','!=',$null)
                ->select('register_time','id')
//                ->select([DB::raw('count(*) as num')])
//                ->groupBy('login_time')
                ->orderBy('register_time','desc')
                ->paginate($pagesize);
//          return $data;
            $And_new_reg = $And_new_reg->count();
            //安卓老注册度
            $And_old_reg=User::when($st,function ($query)use($st,$et,$time){
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('register_time',[$st,$et]);
            })->where('register_time','<',$beginToday)
                ->where('unique_id','!=',$null)
                ->select('register_time','id')
//                ->select([DB::raw('count(*) as num')])
//                ->groupBy('login_time')
                ->orderBy('register_time','desc')
                ->paginate($pagesize);
//          return $data;
            $And_old_reg = $And_old_reg->count();

            $sum_reg = $Ios_new_reg+$Ios_old_reg+$And_new_reg+$And_old_reg;


             $data[] = [
                'time'=> date('Y-m-d',$beginToday),
                'sum_pay'=>$sum_pay,
                'Ios_new_pay'=>$Ios_new_pay,
                'Ios_old_pay'=>$Ios_old_pay,
                'And_new_pay'=>$And_new_pay,
                'And_old_pay'=>$And_old_pay,
                 'sum_active'=>$sum_active,
                 'Ios_new_active'=>$Ios_new_active,
                 'Ios_old_active'=>$Ios_old_active,
                 'And_new_active'=>$And_new_active,
                 'And_old_active'=>$And_old_active,
                 'sum_reg'=>$sum_reg,
                 'Ios_new_reg'=>$Ios_new_reg,
                 'Ios_old_reg'=>$Ios_old_reg,
                 'And_new_reg'=>$And_new_reg,
                 'And_old_reg'=>$And_old_reg

            ];

        }

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
