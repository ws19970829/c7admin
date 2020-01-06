@extends('admin.public.main')
<title>添加管理员 </title>

@section('cnt')
    @include('admin.public.msg')
    <article class="page-container">
        <form class="form form-horizontal" id="form-admin-add" action="{{route('admin.admin.update',$admin)}}" method="post">
            @csrf
            @method('PUT')
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>账号：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ $admin->username }}" placeholder=""  name="username">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>实名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$admin->truename}}" placeholder="" name="truename">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <input name="sex" type="radio" value="先生"
                               @if($admin->sex=='先生') checked @endif>
                        <label for="sex-1">先生</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" value="女士" name="sex" @if($admin->sex=='女士') checked @endif>
                        <label for="sex-2">女士</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$admin->phone}}" placeholder=""  name="phone">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$admin->email}}" placeholder=""  name="email">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder=""  name="password">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder=""  name="password_confirmation">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    @foreach($roleData as $id=>$name)
                        <div class="radio-box">
                            <input name="role_id" type="radio" value="{{$id}}"  @if($id==$admin->role_id) checked @endif>
                            <label for="sex-1">{{$name}}</label>
                        </div>
                    @endforeach
                </div>
            </div>




            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>
@endsection

@section('js')
     <script type="text/javascript" src="{{staticAdmin()}}lib/jquery.validation/1.14.0/jquery.validate.js"></script>
     <script type="text/javascript" src="{{staticAdmin()}}lib/jquery.validation/1.14.0/validate-methods.js"></script>
     <script type="text/javascript" src="{{staticAdmin()}}lib/jquery.validation/1.14.0/messages_zh.js"></script>
     <script>
         $('.skin-minimal input').iCheck({
             checkboxClass: 'icheckbox-blue',
             radioClass: 'iradio-blue',
             increaseArea: '20%'
         });
     </script>

@endsection





