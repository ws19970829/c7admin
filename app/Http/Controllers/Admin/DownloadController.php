<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use App\Models\Services\DownloadServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DownloadController extends BaseController
{
    public function index(Request $request)
    {
//        $download = new DownloadServices();
//        $down = $download->time($request);
////          dd($down);
//        $data = $download->getData($request, 10);
//        dd($data);
////
        //        判断是否是ajax请求
        if($request->ajax()){

            //分页起始位置
            $offset = $request->get('start',0);
            //每页记录数
            $limit = $request->get('length',$this->pagesize);
            $downloadServices =new DownloadServices();
            $count=$downloadServices->time($request);
            $count=count($count);
//            $count=300;
            $data = $downloadServices->getData($request,$limit,$offset);
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
        return view('admin.download.index');
    }

//    public function index()
//    {
//
//        $data = Game::orderBy('create_time','desc')->limit(10)->get(['dow_num','create_time'])->groupBy('create_time')->toArray();
//        $data = Game::orderBy('create_time','desc')
//            ->limit(10)
//            ->get(['dow_num','create_time','game_name'])
//            ->groupBy('create_time');
////        dd($data->toArray());
//        $newData=$data->toArray();
//       foreach ($newData as $k=>$v){
//
//           $newData[$k]['down_sum']=0;
//           $newData[$k]['game_names']=null;
//           foreach ($v as $k1=>$v1){
//               $newData[$k]=[
//                   'down_sum'=>$v1['dow_num']+$newData[$k]['down_sum'],
//                   'game_names'=>$v1['game_name'].','.$newData[$k]['game_names']
//               ];
//           }
//       }
////       dd($newData);
//
//
//        return view('admin.download.index',compact('newData'));
//    }

//    public function gameDown(Request $request){
////        dd($request);
//        return view('admin.download.gamedownload');
//    }


}
