@extends('admin.public.main')
<title>用户等级列表</title>

@section('cnt')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({})"  class="input-text Wdate" style="width:120px;" name="st" id="st" >
            <input type="text" onfocus="WdatePicker({})"  class="input-text Wdate" style="width:120px;" name="et"   id="et" >
            <button name="" id="" class="btn btn-success" type="button" onclick="searchBtn()">
                <i class="Hui-iconfont" >&#xe665;</i> 搜索
            </button>
        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20">  </div>
        <div>
            <table  style="width: 600px;" class="table table-border table-bordered table-bg table-sort" id="mainTable">
                <thead>
                <tr>
                    <th scope="col" colspan="4">下载统计列表</th>
                </tr>
                <tr class="text-c">

                    <th width="100">日期</th>
                    <th width="100">下载次数</th>
                    <th width="100" id="btn">下载列表</th>

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



        const datatable=  $('.table-sort').dataTable({
            //页码修改
            lengthMenu:[10,20,30,50,100],
            // 指定不排序
            columnDefs:[
                {targets:[0,1,2],orderable:false}
            ],
            //指定谁可以排序
            // order:[[0,'desc']],
            //从第几条显示
            displayStart: {{ request()->get('start')?? 0 }},
            //开启服务端分页
            serverSide:true,
            searching:false,
            //ajax配置
            ajax:{
                url:'{{ route("admin.download.index") }}',
                type:'GET',
                data:function(ret){
                    ret.st = $.trim($('#st').val());
                    ret.et = $.trim($('#et').val())
                }
            },
            columns:[
                {data:'time',className:'text-c'},
                {data:'sum',className:'text-c'},
                {data:'',defaultContent:'点击查看',className:'text-c btn-primary'},

            ],
        });
        function searchBtn(){
            datatable.api().ajax.reload();
        }
        $('#mainTable tbody').on('click','tr td:last', function (e) {
            alert(1)

        } );

    </script>
@endsection



