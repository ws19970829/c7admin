
@extends('admin.public.main')

<title>管理员列表</title>
@section('cnt')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">

        @include('admin.public.msg')

        <form>
            <div class="text-c">

                <input type="text" class="input-text"   value="{{ request()->get('ss') }}" style="width:250px" placeholder="输入订单号进行搜索" id="" name="ss">
                <button type="submit" class="btn btn-success" id="" name="">
                    <i class="icon-search"></i>搜索
                </button>
            </div>
        </form>

        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" onclick="delAll()" class="btn btn-danger radius">
                    <i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
                {{--<a href="{{ route('admin.admin.create') }}"  class="btn btn-primary radius">--}}
                {{--<i class="icon-plus"></i> 添加管理员</a>--}}
                {{--<a href="javascript:;" onclick="admin_add('添加管理员','{{ route('admin.admin.create') }}','800','500')" class="btn btn-primary radius">--}}
                {{--<i class="Hui-iconfont">&#xe600;</i> 添加管理员</a>--}}

            </span>



            <table class="table table-border table-bordered table-bg">
                <thead>
                <tr>
                    <th scope="col" colspan="11">玩家支付列表</th>
                </tr>
                <tr class="text-c">
                    <th width="25"><input type="checkbox" name="" value=""></th>
                    <th>用户ID</th>
                    <th>用户昵称</th>
                    <th>订单编号</th>
                    <th>支付金额</th>
                    <th>支付方式</th>
                    <th>支付状态</th>
                    <th>下单时间</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                    <tr class="text-c">
                        <td><input type="checkbox" value="" name="ids[]"></td>
                        <td>{{$item->user_id}}</td>
                        <td>{{$item->user_nickname}}</td>
                        <td>{{$item->order_number}}</td>
                        <td>{{$item->pay_amount}}</td>
                        <td>
                            @if($item->pay_way==0) 平台币 @endif
                            @if($item->pay_way==1) 支付宝 @endif
                            @if($item->pay_way==2) 微信(扫码) @endif
                            @if($item->pay_way==3) 微信app @endif
                            @if($item->pay_way==4) 威富通 @endif
                            @if($item->pay_way==5) 聚宝云 @endif
                            @if($item->pay_way==6) 竣付通 @endif
                        </td>
                        <td>
                            @if($item->pay_status==0) <a class="label label-warning radius" >  未支付 </a> @endif

                            @if($item->pay_status==1) <a class="label label-secondary radius" > 已支付</a> @endif
                        </td>
                        <td>{{$item->pay_time}}</td>
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
@endsection





