<?php

namespace App\Http\Controllers\Admin;

use App\Models\Node;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $ss = $request->get('ss');
        $data = Role::when('ss',function($query)use($ss){
            $query->where('name','like',"%{$ss}%");
        })->paginate($this->pagesize);
        return view('admin.role.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $nodedate = Node::all()->toArray();
        $nodedate = treeLevel($nodedate);
        return view('admin.role.create',compact('nodedate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//        dd($request);
       $data= $this->validate($request,[
           'name'=>'required|unique:roles,name'
        ]);

       $model = Role::create($data);

       $model->nodes()->sync($request->get('node_ids'));
       return redirect(route('admin.role.index'))->with('success','添加角色['.$model->name.']成功');


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
    public function edit(Role $role)
    {
        //
        $nodedate = Node::all()->toArray();
        $nodedate = treeLevel($nodedate);

        //角色当前的权限
        $role_node = $role->nodes()->pluck('id')->toArray();
//        dd($role_node);

        return view('admin.role.edit',compact(['role','nodedate','role_node']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
        $data = $this->validate($request,[
            'name'=>'required|unique:roles,name,'.$role->id
        ]);
        $role->update($data);
        $role->nodes()->sync($request->get('node_ids'));
        return redirect(route('admin.role.index'))->with('success','修改角色成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::destroy($id);
        return ['status'=>0,'msg'=>'删除成功'];
    }
    //全选删除
    public function delall(Request $request){
        $ids= $request->get('ids');
        Role::destroy($ids);
        return ['status'=>0,'msg'=>'批量删除成功'];
    }
}
