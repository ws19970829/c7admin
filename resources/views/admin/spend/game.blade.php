
@extends('admin.public.main')
<title>资讯列表</title>
@section('css')

@endsection
@section('cnt')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 文章管理 <span class="c-gray en">&gt;</span> 文章列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="text-c">
            </span> 日期范围：
            <input type="text" onfocus="WdatePicker({})"  class="input-text Wdate" style="width:120px;" name="st" id="st" >
            <input type="text" onfocus="WdatePicker({})"  class="input-text Wdate" style="width:120px;" name="et"   id="et" >
            <button name="" id="" class="btn btn-success" type="button" onclick="searchBtn()">
                <i class="Hui-iconfont" >&#xe665;</i> 搜索
            </button>
        </div>
        <div>
            <div class="select-box" style="width:150px;">
                <select name="" class="select" size="1" id="company_name">
                    <option >选择公司</option>
                    @foreach($companys as $v)
                        <option value="{{$v}}" name="company_name" >{{$v}}</option>
                    @endforeach
                </select>
            </div>
            <div class="select-box" style="width:150px;" >
                <select name="" class="select" size="1" id="name">
                    <option >选择游戏</option>
                    @foreach($names as $v)
                        <option value="" name="name" >{{$v}}</option>
                    @endforeach
                </select>
            </div>
            <button name="" id="" class="btn btn-success" type="button" onclick="mu()">
                <i class="Hui-iconfont" >&#xe665;</i> 加载
            </button>
        </div>


        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
                <thead>
                <tr>
                                    <th scope="col" colspan="1">日期</th>
                                    <th scope="col" colspan="5" class = "text-c">平台充值</th>
                                    <th scope="col" colspan="5" class = "text-c">平台注册</th>
                                    <th scope="col" colspan="5" class = "text-c">平台活跃</th>
                                </tr>
                <tr class="text-c">
                    <th width="200"></th>
                                        <th width="100">总充值</th>
                                        <th width="100">苹果新增充值</th>
                                        <th width="100">苹果老用户充值</th>
                                        <th width="100">安卓新增充值</th>
                                        <th width="100">安卓老用户充值</th>
                                        <th width="100">总活跃</th>
                                        <th width="100">苹果新增活跃</th>
                                        <th width="100">苹果老用户活跃</th>
                                        <th width="100">安卓新增活跃</th>
                                        <th width="100">安卓老用户活跃</th>
                                        <th width="100">总注册</th>
                                        <th width="100">苹果新增注册</th>
                                        <th width="100">苹果总注册</th>
                                        <th width="100">安卓新增注册</th>
                                        <th width="100">安卓总注册</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript" src="{{staticAdmin()}}lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="{{staticAdmin()}}lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{staticAdmin()}}lib/laypage/1.2/laypage.js"></script>
    <script>


    </script>


    <script>


        const datatable=  $('.table-sort').dataTable({
            //页码修改
            lengthMenu:[10,20,30,50,100],
            // 指定不排序
            columnDefs:[
                {targets:[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,],orderable:false}
            ],
            //指定谁可以排序
            order:[[0,'desc']],
            //从第几条显示
            displayStart: {{ request()->get('start')?? 0 }},
            //开启服务端分页
            serverSide:true,
            searching:false,
            //ajax配置
            ajax:{
                url:'{{ route("admin.spend.index") }}',
                type:'GET',
                data:function(ret){
                    ret.st = $.trim($('#st').val());
                    ret.et = $.trim($('#et').val());
                    ret.company_name = $.trim($('#company_name').find("option:selected").html());
                    ret.name = $.trim($('#name').find("option:selected").html());
                }
            },
            columns:[
                {data:'time',className:'text-c'},
                {data:'sum_pay',className:'text-c'},
                {data:'Ios_new_pay'},
                {data:'Ios_old_pay'},
                {data:'And_new_pay',className:'text-c'},
                {data:'And_old_pay',className:'text-c'},
                {data:'sum_active',className:'text-c'},
                {data:'Ios_new_active'},
                {data:'Ios_old_active'},
                {data:'And_new_active',className:'text-c'},
                {data:'And_old_active',className:'text-c'},
                {data:'sum_reg',className:'text-c'},
                {data:'Ios_new_reg'},
                {data:'Ios_old_reg'},
                {data:'And_new_reg',className:'text-c'},
                {data:'And_old_reg',className:'text-c',}
            ],
        });
        function searchBtn(){
            datatable.api().ajax.reload();
        }
        function mu(){
            datatable.api().ajax.reload();
        }
        $('#company_name').change(function () {
            var company = $(this).val();
            $.ajax({
                url: "{{route('admin.spend.gamename')}}",
                data:{
                    company,
                }
            }).then(ret=>{
                let html = '';
                var data =ret['data'];
                data = ['请选择游戏',...data];
                data.forEach(item=>{
                    html += `<option value="">${item}</option>`
                });
                $('#name').html(html);

            });


        });

    </script>

@endsection








