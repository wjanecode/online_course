@extends('layouts.main')

@section('content')
    <form action="{{ url('/cate/'.$data->id) }}" method="" class="form form-horizontal" id="form-category-add">
        <div id="tab-category" class="HuiTab">
            <div class="tabBar cl">
                <span>修改名称</span>
            </div>
            <div class="tabCon">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>
                        分类名称：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="{{ $data->name }}" placeholder="" id="cate_name" name="cate_name">
                    </div>
                    <div class="col-3">
                    </div>
                </div>
            </div>

            {{ csrf_field() }}
        </div>
        <div class="row cl">
            <div class="col-9 col-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>

@endsection

@section('js')
    <script>
        let a = 1000;
        $(document).ready(function(){
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });

            $("#tab-category").Huitab({
                index:0
            });
            //表单验证
            $("#form-category-add").validate({
                rules:{
                    //标签名不能为空
                    cate_name: "required"
                },
                messages:{
                    //提示信息
                    cate_name:{
                        required: "名称不能为空"
                    }
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",//验证通过，添加valid字段
                submitHandler:function(form){
                    //使用ajaxSubmit,url默认action的
                    $(form).ajaxSubmit({
                        type:"PUT",
                        //data里的数据会追加到表单数据的后面
                        data:{
                            "a": a,
                            //"cate_name": $("#cate_name").val(),
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
                        },
                    });
                }
            });
        });

    </script>

@endsection
