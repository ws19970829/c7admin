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

        <form action="{{route('admin.node.store')  }} " method="post" class="form form-horizontal" id="form-node-add form-add">
            @csrf

            <div class="row cl">
                <label class="form-label col-xs-7 col-sm-3"><span class="c-red">*</span>上级权限：</label>
                <div class="formControls col-xs-8 col-sm-9">
				<span class="select-box" style="width:150px;">
					<select name="pid" class="select" size="1">
						<option value="0">作为顶级权限</option>
						@foreach($data as $id=>$item)
                            <option style="padding-left:{{ $item['level']*20 }} px" value="{{ $item['id'] }}"   >{{$item['html']}}{{ $item['name'] }}</option>
                        @endforeach

					</select>
				</span>
                </div>
            </div>
            {{--<div class="row cl">--}}
            {{--<label class="form-label col-xs-4 col-sm-3">上级菜单：</label>--}}
            {{--<div class="formControls col-xs-1 col-sm-2">--}}
            {{--<span class="select-box">--}}
            {{--<select name="pid" class="select" id="sele">--}}
            {{--<option >请选择顶级权限</option>--}}
            {{--@foreach($pid as $id=>$name)--}}

            {{--<option v="{{ $id }}" name="id1">{{ $name }}</option>--}}
            {{--@endforeach--}}
            {{--</select>--}}
            {{--</span>--}}
            {{--</div>--}}
            {{--<div class="formControls col-xs-1 col-sm-2">--}}
            {{--<span class="select-box">--}}
            {{--<select name="pid" class="select">--}}
            {{--<option >请选择二级权限</option>--}}
            {{--@foreach($data as $id2=>$name)--}}

            {{--<option value="{{ $id }}">{{ $name }}</option>--}}
            {{--@endforeach--}}
            {{--</select>--}}
            {{--</span>--}}
            {{--</div>--}}
            {{--<div class="formControls col-xs-1 col-sm-2">--}}
            {{--<span class="select-box">--}}
            {{--<select name="pid" class="select">--}}
            {{--<option >请选择三级权限</option>--}}
            {{--@foreach($data as $id=>$name)--}}
            {{--<option value="{{ $id }}" >{{ $name }}</option>--}}
            {{--@endforeach--}}
            {{--</select>--}}
            {{--</span>--}}
            {{--</div>--}}

            {{--</div>--}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>权限名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" value="{{ old('name') }}" class="input-text" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">路由别名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" value="{{ old('route_name') }}" class="input-text" name="route_name" placeholder="作为顶级权限的路由别名不需要写">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">菜单：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <label><input name="is_menu" type="radio" value="0" checked>
                            否</label>
                    </div>
                    <div class="radio-box">
                        <label><input type="radio" name="is_menu" value="1">
                            是</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="添加新权限">
                </div>
            </div>
        </form>
    </article>
@endsection
@section('js')
    <script type="text/javascript" src="{{ staticAdmin() }}lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="{{ staticAdmin() }}lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="{{ staticAdmin() }}lib/jquery.validation/1.14.0/messages_zh.js"></script>
{{--    <script>--}}
{{--        $('.skin-minimal input').iCheck({--}}
{{--            checkboxClass: 'icheckbox-blue',--}}
{{--            radioClass: 'iradio-blue',--}}
{{--            increaseArea: '20%'--}}
{{--        });--}}
{{--        $('#form-node-add').validate({--}}
{{--            rules:{--}}
{{--                name:{--}}
{{--                    required:true--}}
{{--                }--}}
{{--            },--}}
{{--            message:{--}}
{{--                name:{--}}
{{--                    required:'权限名称不能为空'--}}
{{--                }--}}
{{--            },--}}
{{--            onkeyup: false,--}}
{{--            // 成功时样式--}}
{{--            success: "valid",--}}
{{--            submitHandler:function (form) {--}}
{{--                form.submit();--}}
{{--            }--}}
{{--        })--}}

{{--        --}}{{--$('#sele').change(function(){--}}
{{--            --}}{{--var id =  $('#sele option:selected').attr('v');--}}
{{--//            alert(id);--}}
{{--            --}}{{--$.ajax({--}}
{{--                --}}{{--url:'{{ route("admin.node.sel") }}',--}}
{{--                --}}{{--type:'get',--}}
{{--                --}}{{--data:{ id }--}}
{{--            --}}{{--}).then(res=>{--}}
{{--                --}}{{--alert(res);--}}
{{--            --}}{{--})--}}

{{--        --}}{{--})--}}

{{--    </script>--}}


@endsection
