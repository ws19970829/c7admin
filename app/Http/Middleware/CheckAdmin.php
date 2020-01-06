<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!auth()->check()){
            return redirect(route('admin.login'))->withErrors(['errors'=>'请您先登录']);
        }

//        个人模型
//        $usermodel = auth()->user();
//
//        //角色模型
//        $rolemodel = $usermodel->role;
//
//        //权限模型的路由别名
//        $auths=$rolemodel->nodes()->pluck('route_name','id')->toArray();
//
//        //过滤空路由
//        $authlist = array_filter($auths);
//        $allowlist=[
//            'admin.index',
//            'admin.welcome',
//            'admin.logout'
//        ];
//
//        //合并俩个路由
//        $authlist = array_merge($authlist,$allowlist);
//        $request->auths = $authlist;
//
//        //获得当前路由
//        $currentroute = $request->route()->getName();
//
//        //获取当前用户名
//        $currentusername = auth()->user()->username;
//        $request->username = $currentusername;
//
//        if(!in_array($currentroute,$authlist)&& $currentusername!='admin'){
//            exit('没有权限');
//        }

        return $next($request);
    }
}
