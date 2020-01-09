<?php

namespace App\Models\Services;
use App\Models\Game;
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
            })->whereBetween('pay_time',[$beginToday,$endToday])
                ->where('sdk_version',1)
                ->orderBy('pay_time','desc')
                ->select('pay_time','pay_amount')
                ->paginate($pagesize);
            $And_new_pay= $And_new_pay->sum('pay_amount');
            //安卓老用户充值
            $And_old_pay=Spend::when($st,function ($query)use($st,$et,$time,$beginToday){
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('pay_time',[$st,$et]);
            })->where('pay_time','<',$beginToday)
                ->where('sdk_version',1)
                ->orderBy('pay_time','desc')
                ->select('pay_time','pay_amount')
                ->paginate($pagesize);
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


    public function getGame(Request $request,int $pagesize=10,int $offset=0){


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
        for ($i=$j;$i<$jj;$i++) {

            $beginToday = strtotime(date('Y-m-d 00:00:00', $truetime2[$i]));
            $endToday = strtotime(date('Y-m-d 23:59:59', $truetime2[$i]));

            $time = [$beginToday, $endToday];

            $st = $request->get('st');
            $et = $request->get('et');

            $company_name = $request->get('company_name');
            $name = $request->get('name');

//            if($company_name=='选择公司'){
//                $company_name = null;
//            }
//            if($name=='选择游戏'){
//                $name = null;
//            }


            $company_name='上海九城';
            $data_name = Game::when($company_name, function ($query) use ($company_name) {
                $query->where('company', $company_name);
            })->groupBy('game_name')->pluck('game_name')->toArray();
//            $name ='sdkdemo(苹果版)';
//            return $data_name;

//return $data_name;
            $And_new_pay = Spend::when($st, function ($query) use ($st, $et) {
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('pay_time', [$st, $et]);
            })->when($data_name, function ($query) use ($data_name) {
                $query->whereIn('game_name', $data_name);
            })->when($name, function ($query) use ($name) {
                $query->where('game_name', $name);
            })->whereBetween('pay_time', [$beginToday, $endToday])
                ->where('sdk_version', 1)
                ->select(['pay_amount'])
                ->paginate($pagesize);

            $And_new_pay = $And_new_pay->sum('pay_amount');
//        return $Ios_new_pay;

            //安卓老活跃度
            $And_old_pay = Spend::when($st, function ($query) use ($st, $et) {
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('pay_time', [$st, $et]);
            })->when($data_name, function ($query) use ($data_name) {
                $query->whereIn('game_name', $data_name);
            })->when($name, function ($query) use ($name) {
                $query->where('game_name', $name);
            })->where('pay_time', '<', $beginToday)
                ->where('sdk_version', 1)
                ->select(['pay_amount'])
                ->paginate($pagesize);
//        return $game;
            $And_old_pay = $And_old_pay->sum('pay_amount');

//        return $And_old_pay;

            //苹果新增活跃
            $Ios_new_pay = Spend::when($st, function ($query) use ($st, $et) {
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('pay_time', [$st, $et]);
            })->when($data_name, function ($query) use ($data_name) {
                $query->whereIn('game_name', $data_name);
            })->when($name, function ($query) use ($name) {
                $query->where('game_name', $name);
            })->whereBetween('pay_time', [$beginToday, $endToday])
                ->where('sdk_version', 2)
                ->select(['pay_amount'])
                ->paginate($pagesize);
            $Ios_new_pay = $Ios_new_pay->sum('pay_amount');
//     return $Ios_new_pay;

            //苹果老活跃度
            $Ios_old_pay = Spend::when($st, function ($query) use ($st, $et) {
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('pay_time', [$st, $et]);
            })->when($data_name, function ($query) use ($data_name) {
                $query->whereIn('game_name', $data_name);
            })->when($name, function ($query) use ($name) {
                $query->where('game_name', $name);
            })->where('pay_time', '<', $beginToday)
                ->where('sdk_version', 2)
                ->select(['pay_amount'])
                ->paginate($pagesize);
            $Ios_old_pay = $Ios_old_pay->sum('pay_amount');
//        return $Ios_old_pay;


            //苹果活跃度
            $null = null;

//        $name = 'sdkdemo(苹果版)';

            $user_id = Spend::whereIn('game_name', $data_name)->groupBy('user_id')->pluck('user_id')->toArray();
//        return $user_id;
//        return $user_id;
            $Ios_new_active = User::when($st, function ($query) use ($st, $et) {
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('login_time', [$st, $et]);
            })->when($data_name, function ($query) use ($data_name) {
                $user_id = Spend::whereIn('game_name', $data_name)->groupBy('user_id')->pluck('user_id')->toArray();
                $query->whereIn('id', $user_id);
            })->when($name, function ($query) use ($name) {
                $user_id = Spend::where('game_name', $name)->groupBy('user_id')->pluck('user_id')->toArray();
                $query->whereIn('id', $user_id);
            })->whereBetween('login_time', [$beginToday, $endToday])
                ->where('unique_id', $null)
                ->select('login_time', 'id')
                ->orderBy('login_time', 'desc')
                ->paginate($pagesize);
            $Ios_new_active = $Ios_new_active->count();


            //苹果老活跃度
            $Ios_old_active = User::when($st, function ($query) use ($st, $et) {
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('login_time', [$st, $et]);
            })->when($data_name, function ($query) use ($data_name) {
                $user_id = Spend::whereIn('game_name', $data_name)->groupBy('user_id')->pluck('user_id')->toArray();
                $query->whereIn('id', $user_id);
            })->when($name, function ($query) use ($name) {
                $user_id = Spend::where('game_name', $name)->groupBy('user_id')->pluck('user_id')->toArray();
                $query->whereIn('id', $user_id);
            })->where('login_time', '<', $beginToday)
                ->where('unique_id', $null)
                ->select('login_time', 'id')
//                ->select([DB::raw('count(*) as num')])
//                ->groupBy('login_time')
                ->orderBy('login_time', 'desc')
                ->paginate($pagesize);
//          return $data;
            $Ios_old_active = $Ios_old_active->count();
//        return $Ios_old_active;

            //安卓活跃值
            $And_new_active = User::when($st, function ($query) use ($st, $et) {
                $st=strtotime(date('Y-m-d 00:00:00',strtotime($st)));
                $et=strtotime(date('Y-m-d 23:59:59',strtotime($et)));
                $query->whereBetween('login_time', [$st, $et]);
            })->when($data_name, function ($query) use ($data_name) {
                $user_id = Spend::whereIn('game_name', $data_name)->groupBy('user_id')->pluck('user_id')->toArray();
                $query->whereIn('id', $user_id);
            })->when($name, function ($query) use ($name) {
                $user_id = Spend::where('game_name', $name)->groupBy('user_id')->pluck('user_id')->toArray();
                $query->whereIn('id', $user_id);
            })->whereBetween('login_time', [$beginToday, $endToday])
                ->where('unique_id', '!=', $null)
                ->select('login_time', 'id')
//                ->select([DB::raw('count(*) as num')])
//                ->groupBy('login_time')
                ->orderBy('login_time', 'desc')
                ->paginate($pagesize);
//          return $data;
            $And_new_active = $And_new_active->count();
            //安卓老活跃度
            $And_old_active = User::when($st, function ($query) use ($st, $et) {
                $st = strtotime(date('Y-m-d 00:00:00', strtotime($st)));
                $et = strtotime(date('Y-m-d 23:59:59', strtotime($et)));
                $query->whereBetween('login_time', [$st, $et]);
            })->when($data_name, function ($query) use ($data_name) {
                $user_id = Spend::whereIn('game_name', $data_name)->groupBy('user_id')->pluck('user_id')->toArray();
                $query->whereIn('id', $user_id);
            })->when($name, function ($query) use ($name) {
                $user_id = Spend::where('game_name', $name)->groupBy('user_id')->pluck('user_id')->toArray();
                $query->whereIn('id', $user_id);
            })->where('login_time', '<', $beginToday)
                ->where('unique_id', '!=', $null)
                ->select('login_time', 'id')
//                ->select([DB::raw('count(*) as num')])
//                ->groupBy('login_time')
                ->orderBy('login_time', 'desc')
                ->paginate($pagesize);
            $And_old_active = $And_old_active->count();

            //苹果新注册
            $Ios_new_reg = User::when($st, function ($query) use ($st, $et) {
                $st = strtotime(date('Y-m-d 00:00:00', strtotime($st)));
                $et = strtotime(date('Y-m-d 23:59:59', strtotime($et)));
                $query->whereBetween('register_time', [$st, $et]);
            })->when($data_name, function ($query) use ($data_name) {
                $user_id = Spend::whereIn('game_name', $data_name)->groupBy('user_id')->pluck('user_id')->toArray();
                $query->whereIn('id', $user_id);
            })->when($name, function ($query) use ($name) {
                $user_id = Spend::where('game_name', $name)->groupBy('user_id')->pluck('user_id')->toArray();
                $query->whereIn('id', $user_id);
            })->whereBetween('register_time', [$beginToday, $endToday])
                ->where('unique_id', $null)
                ->select('register_time', 'id')
//                ->select([DB::raw('count(*) as num')])
//                ->groupBy('login_time')
                ->orderBy('register_time', 'desc')
                ->paginate($pagesize);
//          return $data;
            $Ios_new_reg = $Ios_new_reg->count();
            //苹果老注册
            $Ios_old_reg = User::when($st, function ($query) use ($st, $et) {
                $st = strtotime(date('Y-m-d 00:00:00', strtotime($st)));
                $et = strtotime(date('Y-m-d 23:59:59', strtotime($et)));
                $query->whereBetween('register_time', [$st, $et]);
            })->when($data_name, function ($query) use ($data_name) {
                $user_id = Spend::whereIn('game_name', $data_name)->groupBy('user_id')->pluck('user_id')->toArray();
                $query->whereIn('id', $user_id);
            })->when($name, function ($query) use ($name) {
                $user_id = Spend::where('game_name', $name)->groupBy('user_id')->pluck('user_id')->toArray();
                $query->whereIn('id', $user_id);
            })->where('register_time', '<', $beginToday)
                ->where('unique_id', $null)
                ->select('register_time', 'id')
//                ->select([DB::raw('count(*) as num')])
//                ->groupBy('login_time')
                ->orderBy('register_time', 'desc')
                ->paginate($pagesize);
//          return $data;
            $Ios_old_reg = $Ios_old_reg->count();

            //安卓注册值
            $And_new_reg = User::when($st, function ($query) use ($st, $et) {
                $st = strtotime(date('Y-m-d 00:00:00', strtotime($st)));
                $et = strtotime(date('Y-m-d 23:59:59', strtotime($et)));
                $query->whereBetween('register_time', [$st, $et]);
            })->when($data_name, function ($query) use ($data_name) {
                $user_id = Spend::whereIn('game_name', $data_name)->groupBy('user_id')->pluck('user_id')->toArray();
                $query->whereIn('id', $user_id);
            })->when($name, function ($query) use ($name) {
                $user_id = Spend::where('game_name', $name)->groupBy('user_id')->pluck('user_id')->toArray();
                $query->whereIn('id', $user_id);
            })->whereBetween('register_time', [$beginToday, $endToday])
                ->where('unique_id', '!=', $null)
                ->select('register_time', 'id')
//                ->select([DB::raw('count(*) as num')])
//                ->groupBy('login_time')
                ->orderBy('register_time', 'desc')
                ->paginate($pagesize);
//          return $data;
            $And_new_reg = $And_new_reg->count();
            //安卓老注册度
            $And_old_reg = User::when($st, function ($query) use ($st, $et) {
                $st = strtotime(date('Y-m-d 00:00:00', strtotime($st)));
                $et = strtotime(date('Y-m-d 23:59:59', strtotime($et)));
                $query->whereBetween('register_time', [$st, $et]);
            })->when($data_name, function ($query) use ($data_name) {
                $user_id = Spend::whereIn('game_name', $data_name)->groupBy('user_id')->pluck('user_id')->toArray();
                $query->whereIn('id', $user_id);
            })->when($name, function ($query) use ($name) {
                $user_id = Spend::where('game_name', $name)->groupBy('user_id')->pluck('user_id')->toArray();
                $query->whereIn('id', $user_id);
            })->where('register_time', '<', $beginToday)
                ->where('unique_id', '!=', $null)
                ->select('register_time', 'id')
//                ->select([DB::raw('count(*) as num')])
//                ->groupBy('login_time')
                ->orderBy('register_time', 'desc')
                ->paginate($pagesize);
            $And_old_reg = $And_old_reg->count();

            $data[] = [
                'time'=> date('Y-m-d',$beginToday),
                'sum_pay' => $Ios_new_pay + $Ios_old_pay + $And_new_pay + $And_old_pay,
                'Ios_new_pay' => $Ios_new_pay,
                'Ios_old_pay' => $Ios_old_pay,
                'And_new_pay' => $And_new_pay,
                'And_old_pay' => $And_old_pay,
                'sum_active' => $Ios_new_active + $Ios_old_active + $And_new_active + $And_old_active,
                'Ios_new_active' => $Ios_new_active,
                'Ios_old_active' => $Ios_old_active,
                'And_new_active' => $And_new_active,
                'And_old_active' => $And_old_active,
                'sum_reg' => $Ios_new_reg + $Ios_old_reg + $And_new_reg + $And_old_reg,
                'Ios_new_reg' => $Ios_new_reg,
                'Ios_old_reg' => $Ios_old_reg,
                'And_new_reg' => $And_new_reg,
                'And_old_reg' => $And_old_reg
            ];
        }
        return $data;

    }












}
