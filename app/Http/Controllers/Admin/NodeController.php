<?php

namespace App\Http\Controllers\Admin;

use App\Models\Node;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;

class NodeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //搜索
        $ss = $request->get('ss');
        $data = Node::when('ss',function($query)use($ss){
            $query->where('name','like',"%{$ss}%");
        })->get();
        $data=$data->toArray();
        $data=treeLevel($data);
//        dd($data);
        return view('admin.node.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = Node::get()->toArray();
        $data = treeLevel($data);
//        dd($data);
        return view('admin.node.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $this->validate($request,[
            'name'=>'required'
        ]);
        Node::create($request->except(['_token']));
        return redirect(route('admin.node.index'));

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
    public function edit(Node $node)
    {
//        dd($node->name);
        $data = Node::get()->toArray();

        $data = treeLevel($data);
        $pid = $node->toArray()['pid'];
//        dd($pid);
        if ($pid==0){
            $pidname='作为顶级权限';
        }else{
            $pidname = Node::where('id',$pid)->value('name');
        }

//        dd($pidname);
        return view('admin.node.edit',compact('node','data','pidname'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Node $node)
    {
        //
//        dd($node->toArray());
        $this->validate($request,[
            'name'=>'required|unique:roles,name'
        ]);
        $node->update($request->all());
        return redirect(route('admin.node.index'))->with('success','修改权限成功');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Node::destroy($id);
        return ['status'=>0,'msg'=>'删除成功'];
    }
    //全选删除
    public function delall(Request $request){
        $ids= $request->get('ids');
        Node::destroy($ids);
        return ['status'=>0,'msg'=>'批量删除成功'];
    }
}
