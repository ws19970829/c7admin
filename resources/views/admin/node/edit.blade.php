@extends('admin.public.main')

@section('cnt')
    @include('admin.public.msg')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 权限管理
        <span class="c-gray en">&gt;</span> 添加权限
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <article class="page-container">


        <form action="{{route('admin.node.update',$node)  }} " method="post" class="form form-horizontal" id="form-node-add form-add">
            @csrf
           @method('PUT')
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>上级权限：</label>
                <div class="formControls col-xs-8 col-sm-9">
				<span class="select-box" style="width:150px;">
					<select name="pid" class="select" size="1">
						<option value="0">作为顶级权限</option>
						@foreach($data as $id=>$item)
                            <option style="padding-left:{{ $item['level']*20 }}px" value="{{ $item['id'] }}" @if($pidname==$item['name']) selected @endif >{{$item['html']}}{{ $item['name'] }}</option>
                        @endforeach

					</select>
				</span>
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>权限名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" value="{{ $node->name }}" class="input-text" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">路由别名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" value="{{ $node->route_name }}" class="input-text" name="route_name" placeholder="作为顶级权限的路由别名不需要写">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">菜单：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <label><input name="is_menu" type="radio" value="0" @if($node->is_menu==0) checked @endif>
                            否</label>
                    </div>
                    <div class="radio-box">
                        <label><input type="radio" name="is_menu" value="1"  @if($node->is_menu==1) checked @endif>
                            是</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="修改权限">
                </div>
            </div>
        </form>
    </article>
@endsection
@section('js')
    <script type="text/javascript" src="{{ staticAdmin() }}lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="{{ staticAdmin() }}lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="{{ staticAdmin() }}lib/jquery.validation/1.14.0/messages_zh.js"></script>

    <script>
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
    </script>

@endsection
