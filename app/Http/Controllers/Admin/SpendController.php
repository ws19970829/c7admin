<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
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


    public function game(Request $request){
//        $spendServices =new SpendServices();
//        $data = $spendServices->getGame($request);
//        dd($data);
//        $company="武汉乐谷在线科技有限公司";
//        $data_name = Game::when($company, function ($query) use ($company) {
//            $query->where('company', $company);
//        })->groupBy('game_name')->pluck('game_name')->toArray();
//        dd($data_name);


        if($request->ajax()){

            //分页起始位置
            $offset = $request->get('start',0);
            //每页记录数
            $limit = $request->get('length',$this->pagesize);
            $spendServices =new SpendServices();
            $count=$spendServices->time($request);
            $count=count($count);
//            $count=300;
            $data = $spendServices->getGame($request,$limit,$offset);

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
        //所有公司
        $companys=Game::groupBy('company')->pluck('company')->toArray();
        $companys=array_filter($companys);
//         dump($company) ;
        //所有游戏
        $names=Game::groupBy('game_name')->pluck('game_name')->toArray();
        $names=array_filter($names);
//        return($name) ;

        return view('admin.spend.game',compact('companys','names'));




    }
    public function gamename(Request $request){
        if($request->ajax()){
        $company = $request->get('company');
            $data_name = Game::when($company, function ($query) use ($company) {
                $query->where('company', $company);
            })->groupBy('game_name')->pluck('game_name')->toArray();
        }
        return ['statu'=>0,'data'=>$data_name];
    }


}
