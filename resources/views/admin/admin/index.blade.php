
@extends('admin.public.main')

<title>管理员列表</title>
@section('cnt')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">

        @include('admin.public.msg')

        <form>
            <div class="text-c"> 日期范围：
                <input type="text" onfocus="WdatePicker({})"  class="input-text Wdate" style="width:120px;" name="st" value="{{ request()->get('st') }}">
                <input type="text" onfocus="WdatePicker({})"  class="input-text Wdate" style="width:120px;" name="et" value="{{ request()->get('et') }}">
                <input type="text" class="input-text"   value="{{ request()->get('ss') }}" style="width:250px" placeholder="输入搜索的内容" id="" name="ss">
                <button type="submit" class="btn btn-success" id="" name="">
                    <i class="icon-search"></i>搜用户
                </button>
            </div>
        </form>

        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" onclick="delAll()" class="btn btn-danger radius">
                    <i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
                <a href="{{ route('admin.admin.create') }}"  class="btn btn-primary radius">
                   <i class="icon-plus"></i> 添加管理员</a>
                {{--<a href="javascript:;" onclick="admin_add('添加管理员','{{ route('admin.admin.create') }}','800','500')" class="btn btn-primary radius">--}}
                {{--<i class="Hui-iconfont">&#xe600;</i> 添加管理员</a>--}}

            </span>



        <table class="table table-border table-bordered table-bg">
            <thead>
            <tr>
                <th scope="col" colspan="11">员工列表</th>
            </tr>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="40">ID</th>
                <th width="100">账号</th>
                <th width="100">实名</th>
                <th width="100">角色</th>
                <th width="90">性别</th>
                <th width="90">手机</th>
                <th width="150">邮箱</th>
                <th width="130">加入时间</th>
{{--                <th width="80">状态</th>--}}
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
            <tr class="text-c">

                <td><input type="checkbox" value="{{$item->id}}" name="ids[]"></td>
                <td>{{$item->id}}</td>
                <td>{{$item->username}}</td>
                <td>{{$item->truename}}</td>
                <td>{{$item->role['name']}}</td>
                <td>{{$item->sex}}</td>
                <td>{{$item->phone}}</td>
                <td>{{$item->email}}</td>
                <td>{{$item->created_at}}</td>
{{--                <td>--}}
{{--                    @if($item->deleted_at)--}}
{{--                        <a  class="label label-warning radius" > 禁用</a>--}}
{{--                    @else--}}
{{--                        <a  class="label label-success radius"> 激活</a>--}}
{{--                    @endif--}}
{{--                </td>--}}
                <td>
                <a class="label label-secondary radius"  href="{{ route('admin.admin.edit',$item) }}"> 修改</a>
                <a class="label label-danger radius	del" data-href="{{ route('admin.admin.destroy',$item) }}">删除</a>
                </td>

            </tr>
                @endforeach
            </tbody>
        </table>
<div>
    {{ $data->appends(request()->except('page'))->links()}}
</div>

    </div>

@endsection
@section('js')
    <script type="text/javascript" src="{{staticAdmin()}}lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="{{staticAdmin()}}lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{staticAdmin()}}lib/laypage/1.2/laypage.js"></script>
    <script type="text/javascript">
        /*
            参数解释：
            title	标题
            url		请求的url
            id		需要操作的数据id
            w		弹出层宽度（缺省调默认值）
            h		弹出层高度（缺省调默认值）
        */
        /*管理员-增加*/
        function admin_add(title,url,w,h){
            layer_show(title,url,w,h);
        }
        /*管理员-编辑*/
        function admin_edit(title,url,id,w,h){
            layer_show(title,url,w,h);
        }
    </script>
            <script>
                var   _token ="{{ csrf_token() }}";
                $('.del').click(function(){
                    var url = $(this).attr('data-href');
                    layer.confirm('您真的要删除吗？',{
                        btn:['确认删除','再想一下']
                    },()=>{
                        $.ajax({
                            url,
                            type:'DELETE',
                            data:{ _token }
                        }).then(ret=>{
                            $(this).parents('tr').remove();
                            layer.msg(ret.msg,{icon:1,time:1000});
                        });
                    });
                    return false;
                });
             //全选删除
                function delAll(){
                    var inputs = $('input[name="ids[]"]:checked');
                    var ids = [];
                    inputs.map((key,item)=>{
                        ids.push($(item).val());
                    });
                    $.ajax({
                        url:'{{ route("admin.admin.delall") }}',
                        type:'DELETE',
                        data:{
                            ids,
                            _token
                        }
                    }).then(ret=>{
                        inputs.map((key,item) =>{
                            $(item).parents('tr').remove();

                        });
                    });
                }



            </script>
@endsection





