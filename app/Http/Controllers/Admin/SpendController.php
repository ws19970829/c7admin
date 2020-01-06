<?php

namespace App\Http\Controllers\Admin;

use App\Models\Spend;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Services\SpendServices;

class SpendController extends BaseController
{

    public function index(Request $request){
//        dd(strtotime('2020-01-03'));
//         $request->st='2020-1-1';
//         $request->et='2020-1-3';
//        $spendServices =new SpendServices();
//        $count=$spendServices->time($request);
//////        dd($count);
//        $data = $spendServices->getData($request,20);
//////
//        dd($data);
//        $count=count($count);

//        判断是否是ajax请求
        if($request->ajax()){

            //分页起始位置
            $offset = $request->get('start',0);
            //每页记录数
            $limit = $request->get('length',$this->pagesize);
            $spendServices =new SpendServices();
            $count=$spendServices->time($request);
            $count=count($count);
//            $count=300;
            $data = $spendServices->getData($request,$limit,$offset);
            //返回指定格式的json数据，return 返回的就是json数据
            return [
                // 客户端调用服务器端次数标识
                'draw' => $request->get('draw'),
                // 获取数据记录总条数
                'recordsTotal' => $count,
                // 数据过滤后的总数量
                'recordsFiltered' => $count,
                // 数据
                'data' => $data
            ];
        }
//
       return view('admin.spend.index');

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
//    {
////        $a=date("Y-m-d",strtotime("-13 day"));
////        dd(strtotime($a));
//
////        用户注册最早时间
//        $oldtime = User::orderBy('register_time','asc')->value('register_time');
//        $newoldtime= strtotime($oldtime);
//        $time=date("Y-m-d",strtotime("0 day"));
//        $newtime=strtotime($time);
//        $length = ($newtime - $newoldtime) /86400;//367
//        $truetime = [];$truetime2=[];
//        for ($i=0;$i<= $length;$i++){
//            $truetime[] =  date("Y-m-d",strtotime( date("Y-m-d",strtotime("- $i day"))));
//        }
//        for ($i=0;$i<= $length;$i++){
//            $truetime2[] =  strtotime(date("Y-m-d",strtotime("- $i day"))) ;
//        }
//
//        //充值
//        $red = Spend::whereIn('pay_time',$truetime2)->where('sdk_version',1)->select('pay_amount','pay_time')->orderBy('pay_time','desc')->paginate(10);
//        $And_data = Spend::whereIn('pay_time',$truetime2)->where('sdk_version',1)->select('pay_amount','pay_time')->orderBy('pay_time','desc')->paginate(10)->toArray();
//
////        dd($And_data['data']);
////        return view('admin.spend.index',compact('data'));
////        dd($Ios_data);
//        $new_And_data = [];
//        foreach ($And_data['data'] as $k=>$v){
//            $new_And_data[$v['pay_time']][]=$v['pay_amount'];
//        }
//
//        foreach ($new_And_data as $k=>$v){
//            $new_And_data[$k]=[
//                'new_And'=>array_sum($v),
//            ];
//        }
////        dd($new_And_data);
//
////        foreach ($new_And_data as $k=>$v){
////            $new_And_data[]=[
////                'new_And'=>array_sum($v),
////            ];
////        }
////        dd($new_And_data);
//
//
////dump($new_And_data);
//        $Ios_data = Spend::whereIn('pay_time',$truetime2)->where('sdk_version',2)->select('pay_amount','pay_time')->orderBy('pay_time','desc')->paginate(10)->toArray();
//        $new_Ios_data = [];
//        foreach ($Ios_data['data'] as $k=>$v){
//            $new_Ios_data[$v['pay_time']][]=$v['pay_amount'];
//        }
//
//        foreach ($new_Ios_data as $k=>$v){
//            $new_Ios_data[$k]=[
//                'new_Ios'=>array_sum($v),
//            ];
//        }
////dump($new_Ios_data);
//
////       dd($newdata);
//
//
//        //活跃
//        $null=null;
//        $res_Ios = User::whereIn('login_time',$truetime2)->where('unique_id',$null)->select('login_time')->orderBy('login_time','desc')->paginate($this->pagesize)->toArray();
//        $new_res_Ios = [];
//        foreach ($res_Ios['data'] as $k=>$v){
//            $new_res_Ios[$v['login_time']][]=1;
//        }
//        foreach ($new_res_Ios as $k=>$v){
//            $new_res_Ios[$k]=[
//                'new_Ios_active'=>array_sum($v),
//            ];
//        }
////dump($new_res_Ios);
//        $res_And = User::whereIn('login_time',$truetime2)->where('unique_id','!=',$null)->select('login_time')->orderBy('login_time','desc')->paginate($this->pagesize)->toArray();
////       dd($res_And);
//        $new_res_And = [];
//        foreach ($res_And['data'] as $k=>$v){
//            $new_res_And[$v['login_time']][]=1;
//        }
//        foreach ($new_res_And as $k=>$v){
//            $new_res_And[$k]=[
//                'new_And_active'=>array_sum($v),
//            ];
//        }
////         dd($new_res_And);
//
//
////        注册
//        $reg_Ios = User::whereIn('login_time',$truetime2)->where('unique_id',$null)->select('register_time')->orderBy('register_time','desc')->paginate($this->pagesize)->toArray();
//        $new_reg_Ios = [];
//        foreach ($reg_Ios['data'] as $k=>$v){
//            $new_reg_Ios[$v['register_time']][]=1;
//        }
//        foreach ($new_reg_Ios as $k=>$v){
//            $new_reg_Ios[$k]=[
//                'new_Ios_register'=>array_sum($v),
//            ];
//        }
////   dump($new_reg_Ios);
//
//        $reg_And = User::whereIn('login_time',$truetime2)->where('unique_id','!=',$null)->select('register_time')->orderBy('register_time','desc')->paginate($this->pagesize)->toArray();
//        $new_reg_And = [];
//        foreach ($reg_And['data'] as $k=>$v){
//            $new_reg_And[$v['register_time']][]=1;
//        }
//        foreach ($new_reg_And as $k=>$v){
//            $new_reg_And[$k]=[
//                'new_And_register'=>array_sum($v),
//            ];
//        }
////        dump($new_reg_And);
//        $newdata=[];
//        $newdata=array_merge_recursive($new_And_data,$new_Ios_data,$new_res_Ios,$new_res_And,$new_reg_Ios,$new_reg_And);
////dd($newdata);
//
////        $And_data = Spend::whereIn('pay_time',$truetime2)->where('sdk_version',1)->select('pay_amount','pay_time')->orderBy('pay_time','desc')->paginate(10)->toArray();
////         dd($And_data['data']);
//
//        return view('admin.spend.index',compact('red','newdata'));
//    }


}
