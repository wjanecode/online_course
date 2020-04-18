@extends('layouts.main')
@section('header')

@endsection
@section('content')
    <form action="" method="post" class="form form-horizontal" id="form-admin-role-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ old('name') }}" placeholder="" id="name" name="name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">备注：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="" name="description">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">权限：</label>
            <div class="formControls col-xs-8 col-sm-9">
                @foreach($top_permissions as $top_permission)
                <dl class="permission-list">
                    <dt>
                        <!---顶级权限作为菜单-->
                        <label>
                            <input type="checkbox" value="{{ $top_permission->id }}" >
                            {{ $top_permission->name }}</label>
                    </dt>
                    <dd>
                        <dl class="cl permission-list2">
                            <dt>
                                <label class="">
                                    <input type="checkbox" value="{{ $top_permission->id }}" name="permissions[]" >
                                    {{ $top_permission->name }}</label>
                            </dt>
                            <dd>

                                @foreach($top_permission->son as $permission)
                                <label class="">
                                    <input type="checkbox" value="{{ $permission->id }}" name="permissions[]" >
                                    {{ $permission->name }}
                                </label>
                                @endforeach
                            </dd>
                        </dl>

                    </dd>
                </dl>
                @endforeach
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok"></i> 确定</button>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $(".permission-list dt input:checkbox").click(function(){
                $(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
            });
            $(".permission-list2 dd input:checkbox").click(function(){
                var l =$(this).parent().parent().find("input:checked").length;
                var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
                if($(this).prop("checked")){
                    $(this).closest("dl").find("dt input:checkbox").prop("checked",true);
                    $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
                }
                else{
                    if(l==0){
                        $(this).closest("dl").find("dt input:checkbox").prop("checked",false);
                    }
                    if(l2==0){
                        $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
                    }
                }
            });

            $("#form-admin-role-add").validate({
                rules:{
                    name:{
                        required:true,
                    },
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type: "POST",
                        url: "{{ url('/role') }}",
                        data:{
                            '_token':"{{ csrf_token() }}",
                        },
                        success: function (response) {

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
            });
        });
    </script>

@endsection
