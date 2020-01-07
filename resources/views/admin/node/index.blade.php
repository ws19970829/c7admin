
@extends('admin.public.main')

@section('cnt')
    @include('admin.public.msg')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 权限中心 <span class="c-gray en">&gt;</span> 权限管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="pd-20">
        <form>
            <div>
                <input type="text" class="input-text"   value="{{ request()->get('ss') }}" style="width:250px" placeholder="输入搜索的内容" id="" name="ss">
                <button type="submit" class="btn btn-success "  name="" >
                    <i class="icon-search"></i>搜索权限
                </button>
            </div>
        </form>

        <div class="cl pd-5 bg-1 bk-gray mt-20">
    <span class="l">
        <a  class="btn btn-danger radius " onclick="delAll()">
            <i class="icon-trash"></i>批量删除
        </a>
{{--        <a href="javascript:;" data-url="{{ route('admin.node.create') }}" id="add" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加权限</a>--}}
    <a href="{{ route('admin.node.create') }}"  class="btn btn-primary radius"><i class="icon-plus"></i>添加权限</a>
    </span>
            <span class="r">共有数据：<strong>88</strong> 条</span>
        </div>
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="80">ID</th>
                <th width="300">节点名称</th>
                <th>路由别名</th>
                <th>是否菜单</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr class="text-c" >
                    <td><input type="checkbox" value="{{ $item['id'] }}" name="ids[]" ></td>
                    <td>{{ $item['id'] }}</td>
                    <td style="padding-left:{{ $item['level']*20 }}px">{{$item['html']}}{{ $item['name'] }}</td>
                    <td>{{$item['route_name']}}</td>
                    <td>
                        @if($item['is_menu'] == '0')
                            <span class="label label-warning radius">否</span>
                        @else
                            <span class="label label-success radius">是</span>
                        @endif
                    </td>

                    <td >
                        <a class="label label-success radius"  href="{{ route('admin.node.edit',$item) }}"> 修改</a>
                        <a class="label label-danger radius del"  data-href="{{ route('admin.node.destroy',$item) }}">
                            删除
                        </a>
                        {{--{!! editBtn('admin.node.edit') !!}--}}
                        {{--{!! delBtn('admin.node.destroy') !!}--}}
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
            {{--{{ $data->appends(request()->except('page'))->links()}}--}}
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ staticAdmin()}}lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="{{ staticAdmin()}}lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{ staticAdmin()}}lib/laypage/1.2/laypage.js"></script>
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
                url:'{{ route("admin.node.delall") }}',
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

