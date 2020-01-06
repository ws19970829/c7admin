<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Services\AdminServices;
use Illuminate\Http\Request;


class AdminController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
//        $data = Admin::orderBy('id','desc')->paginate($this->pagesize);
        $data = (new AdminServices())->getList($request,$this->pagesize);
        return view('admin.admin.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //角色
        $roleData = Role::pluck('name','id');
        return view('admin.admin.create',compact('roleData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {

//        $this->validate($request,[
//           'username'=>'required|unique:admins,username',
//            'truename'=>'required|',
//            'email'=>'required|email',
//            'password'=>'required|confirmed',
//            'role_id'=>'required'
//
//        ],
//            ['role_id.required'=>'角色必须选择一个']);
        $data =$request->except(['_token','password_confirmation']);

        $model = Admin::create($data);
        return redirect(route('admin.admin.index'))->with('success','添加用户['.$data['truename'].']成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)

    {
//        dd($admin);
        $roleData = Role::pluck('name','id');

       return view('admin.admin.edit',compact('admin','roleData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //

        $admin->update($request->except(['_token','password_confirmation']));

        return redirect(route('admin.admin.index'))->with('success','修改用户['.$request->get('truename').']成功');;


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
//        dd(1);
        Admin::destroy($id);
        return ['status'=>0,'msg'=>'删除成功'];
    }
    //全选删除
    public function delall(Request $request){
        $ids= $request->get('ids');
        Admin::destroy($ids);
        return ['status'=>0,'msg'=>'批量删除成功'];
    }
}
