@extends('layouts.main')

@section('content')

    <form action="" method="post" class="form form-horizontal" id="form-permission-add">
        <div id="tab-permission" class="HuiTab">
            <div class="tabBar cl">
                <span>添加权限</span>
            </div>
            <div class="tabCon">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>
                        权限名称：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="" id="name" name="name">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="col-3">
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">父级菜单</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <select name="pid" id="">
                            <option value="0" selected>--默认顶级权限--</option>
                            @if(!is_null($top_permissions))
                                @foreach($top_permissions as $top_permission)
                                    <option value="{{ $top_permission->id }}">{{ $top_permission->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                {{ csrf_field() }}
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>
                        路由别名：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text @error('routename') is-invalid @enderror" value="{{ old('routename') }}" placeholder="" id="routename" name="routename">
                        @error('routename')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="col-3">
                    </div>
                </div>

                <div class="row cl">
                    <div class="col-9 col-offset-3">
                        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                    </div>
                </div>
            </div>

        </div>
    </form>


@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });

            $("#tab-permission").Huitab({
                index:0
            });
            $('#form-permission-add').validate({
               rule:{
                   name: {
                       required: true,
                       minlength:2,
                       maxlength:20,
                   },
                   routename:{
                       required:true,
                   }
               },
                message:{
                    name:{
                        required: "权限名称不能为空",
                        range: "名称范围为2到20个字符"
                    },
                    routename:{
                        required: "路由别名不能为空",
                    }
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type: "POST",
                        url: "{{ url("/permission") }}",
                        // data: {
                        // },
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
            })
        })
    </script>

@endsection
