@extends('admin.public.main')

@section('cnt')
    @include('admin.public.msg')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 角色管理
        <span class="c-gray en">&gt;</span> 修改角色
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <article class="page-container">


        <form action="{{ route('admin.role.update',$role) }}" method="post" class="form form-horizontal" id="form-member-add">
            @csrf
            @method('PUT')
            {{--<div class="row cl">--}}
                {{--<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色ID：</label>--}}

                {{--<div class="formControls col-xs-8 col-sm-9">--}}

                    {{--<input type="text" value="{{ $role->id }}" class="input-text" name="id">--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色：</label>

                <div class="formControls col-xs-8 col-sm-9">

                    <input type="text" value="{{ $role->name }}" class="input-text" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <ul>
                        @foreach($nodedate as $item)
                            <li style="padding-left: {{$item['level']*20}}px;">
                                <input type="checkbox" value="{{ $item['id'] }}" name="node_ids[]"
                                       @if(in_array($item['id'],$role_node)) checked @endif>
                                {{ $item['html'] }}{{ $item['name'] }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="修改角色">
                </div>
            </div>
        </form>
    </article>
@endsection
@section('js')
    <script>
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
    </script>
@endsection
