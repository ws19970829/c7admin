@extends('admin.public.main')

@section('cnt')
    @include('admin.public.msg')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户中心 <span class="c-gray en">&gt;</span> 用户添加 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <article class="page-container">
        <form action="{{ route('admin.role.store') }}" method="post" class="form form-horizontal" id="form-member-add">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色：</label>
                <div class="formControls col-xs-8 col-sm-8">
                    <input type="text" class="input-text" value="" placeholder="" name="name" >
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <ul>
                        @foreach($nodedate as $item)
                            <li style="padding-left:{{ $item['level']*20 }}px">
                                <input type="checkbox"  value="{{ $item['id'] }}"  name="node_ids[]">
                                {{$item['name']}}
                            </li>
                        @endforeach
                    </ul>


                </div>
            </div>


            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;添加角色&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>
@endsection
