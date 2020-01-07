<?php

namespace App\Http\Controllers\Admin;

use App\Models\Spend;
use App\Models\User;
use App\Models\UserLoginRecords;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = User::with('userLoginRecords')->orderBy('id','desc')->paginate($this->pagesize);
//        dd($data->toArray());
        return view('admin.user.index',compact('data'));

    }

    public function userOrder(Request $request){

        $ss=$request->get('ss');
        $data=Spend::when($ss,function ($query)use($ss){
            $query->where('order_number',$ss);
        })->select('user_id','user_nickname','order_number','pay_amount','pay_way','pay_status','pay_time')
            ->orderBy('id','desc')
            ->paginate($this->pagesize);
//        dd($data);
        return view('admin.user.userorder',compact('data'));
    }
    public function userCharge(Request $request){

        $ss=$request->get('ss');
        $data=Spend::when($ss,function ($query)use($ss){
            $query->where('user_account',$ss)->orwhere('user_nickname',$ss);
        })->select('user_account','user_nickname','props_name','order_number','pay_amount','pay_way','pay_status','pay_time')
            ->orderBy('id','desc')
            ->paginate($this->pagesize);
//        dd($data);
        return view('admin.user.usercharge',compact('data'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
