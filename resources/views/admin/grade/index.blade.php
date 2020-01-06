@extends('admin.public.main')
<title>用户等级列表</title>

@section('cnt')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name="">
            <button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> </span>  </div>
        <table  style="width: 600px;" class="table table-border table-bordered table-bg" >
            <thead>
            <tr>
                <th scope="col" colspan="4">用户等级列表</th>
            </tr>
            <tr class="text-c">

                <th width="100">等级</th>
                <th width="100">用户数量</th>
                <th width="100">名单</th>
                {{--<th>id</th>--}}


            </tr>
            </thead>
            <tbody>
            @foreach($data as $k=>$item)
                <tr class="text-c">
                    <td>{{$item->vip_level}}</td>
                    <td>{{$item->num}}</td>
                    <td>
                        <a href=" {{route('admin.grade.user',['id'=>$item->vip_level])}} ">
                            点击查看
                        </a>

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
    <script>

    </script>
@endsection



