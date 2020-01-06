<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;

class LoginController extends Controller
{
    //
    public function index(){
//        $a=bcrypt(123456);
//        dump($a);

        return view('admin.login.index');
    }
    public function dologin(Request $request){

        $data = $this->validate($request,[
            'username'=>'required',
            'password'=>'required',
            'captcha'=>'required|captcha'
        ],[
            'captcha.required'=>'验证码不能为空'
        ]);
        unset($data['captcha']);
        $bools = auth()->attempt($data);
//        dd($bools);

        if(!$bools){
         return redirect(Route('admin.login'))->withErrors(['errors'=>'用户登录失败']);
        }

        return redirect(Route('admin.index'));
    }
}
