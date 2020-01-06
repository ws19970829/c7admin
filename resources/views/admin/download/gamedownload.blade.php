@extends('admin.public.main')
<title>用户等级列表</title>

@section('cnt')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">

        <div class="cl pd-5 bg-1 bk-gray mt-20">  </div>
        <div>



            <table  style="width: 600px;" class="table table-border table-bordered table-bg" >
            <thead>
            <tr>
            <th scope="col" colspan="4">游戏下载列表</th>
            </tr>
            <tr class="text-c">

            <th width="100">游戏名称</th>
            <th width="100">下载次数</th>

            </tr>
            </thead>
            <tbody>

            <tr class="text-c">
            <td></td>

          <td></td>
            </td>


            </tr>



            </tbody>
            </table>
        </div>
    </div>



@endsection

@section('js')
    <script type="text/javascript" src="{{staticAdmin()}}lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="{{staticAdmin()}}lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{staticAdmin()}}lib/laypage/1.2/laypage.js"></script>
    <script>
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
    </script>
@endsection



