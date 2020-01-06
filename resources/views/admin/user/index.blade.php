
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

                <tr class="text-c">
                    <th width="25"><input type="checkbox" name="" value=""></th>
                    <th width="100">玩家账号</th>
                    <th width="100">平台ID</th>
                    <th width="100">充值金额</th>
                    <th width="100">平台币余额</th>
                    <th width="100">现金余额</th>
                    <th width="100">账号状态</th>
                    <th width="100">优惠券数量</th>
                    <th width="100">身份证认证状态</th>
                    <th width="100">注册来源</th>
                    <th width="100">注册方式</th>
                    <th width="100">注册时间</th>
                    <th width="100">注册IP</th>
                    <th width="100">上次登录时间</th>
                    <th width="100">最后登录时间</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                <tr class="text-c">
                    <td><input type="checkbox" value="{{$item->id}}" name="ids[]"></td>
                    <td>{{$item->account}}</td>
                    <td>无</td>
                    <td>{{$item->cumulative}}</td>
                    <td>{{$item->balance}}</td>
                    <td>{{$item->balance}}</td>
                    <td>

                            @if( $item->age_status ==0 )未审核 @endif
                            @if( $item->age_status ==1)未通过 @endif
                            @if( $item->age_status ==2)已通过 @endif

                    </td>
                    <td>1</td>
                    <td>
                       @if($item->anti_addiction==0) 未认证
                        @else 已认证
                    @endif
                    <td>{{$item->register_way}}</td>
                    <td>
                            @if( $item->register_type==0 )游客 @endif
                            @if( $item->register_type ==1)账号 @endif
                            @if( $item->register_type ==2)手机 @endif
                            @if( $item->register_type ==3)微信 @endif
                            @if( $item->register_type ==4)QQ @endif
                            @if( $item->register_type ==5)百度 @endif
                                @if( $item->register_type ==6)微博 @endif
                    </td>
                    <td>{{$item->register_time}}</td>
                    <td>{{$item->register_ip}}</td>
                    <td>

                        {{$item->user_login_records[0]['login_time']}} </td>
                    <td>

                            {{$item->user_login_records[0]['down_time']}} </td>

                    <td>
                        <a class="label label-secondary radius"  href="{{ route('admin.user.edit',$item) }}"> 修改</a>
                        <a class="label label-danger radius	del" data-href="{{ route('admin.user.destroy',$item) }}">删除</a>
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





