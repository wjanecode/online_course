@extends('layouts.main')

@section('content')
    <form action="" method="post" class="form form-horizontal" id="form-admin-role-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>选择角色：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select name="rid" id="">
                    <option value="{{ $user->role->id }}" selected>{{ $user->role->name }}</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        {{ csrf_field() }}
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <button type="submit" onclick="" class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok"></i> 确定</button>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function () {

            $('#form-admin-role-add').validate({
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        url: '{{ url("/user/role/$user->id") }}',
                        type: 'POST',
                        success:function (response) {
                            //判断返回数据的status是否为0,不为0即成功
                            if (response.status !== 0){
                                //成功弹窗
                                success_prompt(response.msg);
                                //2秒后关闭创建窗口
                                setTimeout(function () {
                                    var index = parent.layer.getFrameIndex(window.name);
                                    parent.layer.close(index);
                                },2000)
                            }else{
                                //失败弹窗
                                fail_prompt(response.msg);
                            }
                        },
                        error:function(response) {
                            console.log(response.msg);
                        }
                    });
                }
            })
         })
    </script>

@endsection

