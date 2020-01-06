<?php

namespace App\Http\Controllers\Admin;

use App\Models\Node;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
//        $bools = auth()->user();
//        dd($bools);
        $userModel = auth()->user();
        $roleModel = $userModel->role;
        if($userModel->username!=='admin'){
            $nodeData = $roleModel->nodes()->where('is_menu','1')->get(['id','name','pid','route_name'])->toArray();
        }else{
            $nodeData= Node::where('is_menu','1')->get(['id','name','pid','route_name'])->toArray();

        }
        $nodeData = subTree($nodeData);
//        dd($nodeData);

        return view('admin.index.index',compact('nodeData'));
    }

    //欢迎页
    public  function welcome(){
        return view('admin.index.welcome');
    }

    //后台用户退出
    public function logout(){
        auth()->logout();
        return redirect(route('admin.login'))->with(['success'=>'用户退出成功']);
    }
}
