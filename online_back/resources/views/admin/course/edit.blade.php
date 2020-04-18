@extends('layouts.main')
@section('header')
    {{--    webuploader--}}
    <!--引入CSS-->
    <link rel="stylesheet" type="text/css" href="/node_modules/webuploader/webuploader.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

@endsection

@section('content')

    {{--    表单--}}
    <form action="" method="post" class="form form-horizontal" id="form-category-add">
        <div id="tab-category" class="HuiTab">
            <div class="tabBar cl">
                <span>添加课程</span>
            </div>
            <div class="tabCon">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">
                        <span class="c-red">*</span>
                        课程名称：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="{{ $course->name }}" placeholder="" id="course_name" name="course_name">
                    </div>
                    <div class="col-3">
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">缩略图</label>
                <div class="formControls col-xs-8 col-sm-9 temp-image">
                    <div id="uploader-demo" class="wu-example">

                        <div id="fileList" class="uploader-list"></div>
                        <div id="filePicker" class="webuploader-container">
                            <div class="webuploader-pick">选择图片</div>
                            <div id="rt_rt_1e5f5k0j7emmbvl1vrpaijat44" style="position: absolute; top: 0px; left: 0px; width: 94px; height: 44px; overflow: hidden; bottom: auto; right: auto;">
                                <input  disabled type="file" name="file" multiple="false"class="webuploader-element-invisible"  accept="image/*">
                                <label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label>
                                <input type="text" hidden value="" name="tmp_image">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">
                    <span class="c-red">*</span>
                    选择或新增分类:</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select name="cates[]" class="js-example-placeholder-multiple js-states" style="width: 100%" id="id_label_multiple" multiple="multiple">

                        @foreach($course->cate as $cate)
                            <option value="{{ $cate->id }}" selected>{{ $cate->name }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="col-3">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">
                    <span class="c-red">*</span>
                    简介：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea type="text" class="input-text" rows="3" name="description">{{ $course->description }}</textarea>
                </div>
                <div class="col-3">
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
    <!--引入JS-->
    <script type="text/javascript" src="/node_modules/webuploader/webuploader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>


        /**缩略图异步上传**/
            //缩略图上传成功后返回的路径和图片名
            // var tmp_image_name = '';
            //异步上传图片
            // 初始化Web Uploader
        var uploader = WebUploader.create({

                // 选完文件后，是否自动上传。
                auto: true,

                //追加请求内容,加csrf_token
                formData: {
                    // 这里的token是外部生成的长期有效的，如果把token写死，是可以上传的。
                    _token:'{{csrf_token()}}'
                },

                //限制上传数量
                fileNumLimit:1,

                // swf文件路径
                swf: window.BASE_URL + '/node_modules/webuploader/Uploader.swf',

                // 文件接收服务端。
                server: '{{ url('/component/uploader') }}',

                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '#filePicker',

                // 只允许选择图片文件。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                }
            });


        /**图片回显,还没搞懂
        var getFileBlob = function (url, cb) {
            var xhr = new XMLHttpRequest();
            //回显图片,获取地址,转成文件
            xhr.open("GET", "{{ url('/component/filelists/'.$course->id) }}");
            xhr.responseType = "blob";
            xhr.addEventListener('load', function() {
                cb(xhr.response);
            });
            xhr.send();
        };

        var blobToFile = function (blob, name) {
            blob.lastModifiedDate = new Date();
            blob.name = name;
            return blob;
        };

        var getFileObject = function (filePathOrUrl, cb) {
            getFileBlob(filePathOrUrl, function (blob){
                filename=filePathOrUrl.substring(filePathOrUrl.lastIndexOf('/')+1);
                cb(blobToFile(blob,filename));
            });
        };

        var pictures = [];//图片路径数组
        $.each(pictures, function (index, item) {
            if(item)
            {
                //console.log(item);
                getFileObject(item,function (fileObject) {
                    var wuFile = new WebUploader.Lib.File(WebUploader.guid('rt_'), fileObject);
                    var file = new WebUploader.File(wuFile);
                    uploader.addFiles(file);

                })
            }
            sleep(100);
        });

        function sleep(delay) {
            var start = (new Date()).getTime();
            while ((new Date()).getTime() - start < delay) {
                continue;
            }
        }
         **/


        //图片显示,前面回显没法用的备用方法
        //判断有没有新上传图片(新上传会赋值给input)
        if ($("input[name='tmp_image']").val() == ''){
            //没有新上传,显示服务器的图片
            $('#uploader-demo').append("<img id='image_show' src=\"{{ url($course->cover) }}\" alt=\"\" width=\"100\" height=\"100\">");
            //赋值给input
            $("input[name='tmp_image']").val("{{ $course->cover }}");
        }

        $list = $('#fileList');
        // 当有文件添加进来的时候
        uploader.on( 'fileQueued', function( file ) {
            var $li = $(
                '<div id="' + file.id+ '" class="file-item thumbnail">' +
                '<img>' +
                '<div class="info">' + file.name + '</div>' +
                '</div>'
                ),
                $img = $li.find('img');


            // $list为容器jQuery实例
            //单文件上传先清空之前的
            $list.empty();
            $list.append( $li );

            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader.makeThumb( file, function( error, src ) {
                if ( error ) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img.attr( 'src', src );
            }, 100, 100 );
        });

        // 文件上传过程中创建进度条实时显示。
        uploader.on( 'uploadProgress', function( file, percentage ) {
            var $li = $( '#'+file.id ),
                $percent = $li.find('.progress span');

            // 避免重复创建
            if ( !$percent.length ) {
                $percent = $('<p class="progress"><span></span></p>')
                    .appendTo( $li )
                    .find('span');
            }

            $percent.css( 'width', percentage * 100 + '%' );
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function( file,response ) {
            $( '#'+file.id ).addClass('upload-state-done');
            //获取图片新地址
            if (response.status){
                $("input[name='tmp_image']").val(response.msg);
            }
            //console.log(response.msg)
            console.log($("input[name='tmp_image']").val());
            //有新上传,去掉图片显示
            $('#image_show').attr('hidden',true);
        });

        // 文件上传失败，显示上传出错。
        uploader.on( 'uploadError', function( file ) {
            var $li = $( '#'+file.id ),
                $error = $li.find('div.error');

            // 避免重复创建
            if ( !$error.length ) {
                $error = $('<div class="error"></div>').appendTo( $li );
            }

            $error.text('上传失败');
        });

        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on( 'uploadComplete', function( file ) {
            $( '#'+file.id ).find('.progress').remove();
        });
        // 所有文件上传成功后调用
        uploader.on('uploadFinished', function () {
            //清空队列
            uploader.reset();
        });
        //只允许上传一个，每次文件加入队列前触发
        uploader.on('beforeFileQueued',function(){
            uploader.reset();
            uploader.refresh();
        });

        /**表单上传**/
        $(document).ready(function(){


            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });

            $("#tab-category").Huitab({
                index:0
            });
            $("#form-category-add").validate({
                rules:{
                    name:{
                        required:true,
                        maxlength:50,
                        minlength:2,
                    }
                },
                message:{
                    name:{
                        required: "分类名称不能为空",
                        range: "名称范围为2到50个字符"
                    }
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type: "PUT",
                        url: "{{ url("course/$course->id") }}",
                        // //data数据会补充到表单数据的后面
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
            });


            //分类选择框
            $(".js-example-placeholder-multiple").select2({
                tags: true,
                //placeholder占位提示文字
                placeholder: '选择相关分类',
                //minimumInputLength 最小需要输入多少个字符才进行查询，与之相关的maximumSelectionLength表示最大输入限制。
                //minimumInputLength: 2,
                ajax: {
                    url: '/api/cate',//远程地址
                    type:'GET',//请求方法
                    dataType: 'json',//要求回调的数据格式
                    delay: 250,//延迟查询
                    headers: {
                        Accept: "application/json; charset=utf-8,",
                        //添加api_token验证,先在user表中添加api_token字段
                        Authorization:window.apiToken,
                    },
                    //查询
                    data: function (params) {
                        return {
                            // 1.keyword: params.term 查询参数（params.term表示输入框中内容，
                            // keyword发生到服务器的参数名；所以这里你可以添加自定义参数，如：stype:'person'）
                            keyword: params.term
                        };
                    },
                    // 2.processResults中results: data返回数据（返回最终数据给results，
                    // 如果我的数据在data.res下，则返回data.res。这个与服务器返回json有关）
                    processResults: function (data, params) {
                        return {
                            ////关于返回的 json的格式：select2默认json格式为[{id:1,text:'text'},{id:2,text:'text'}]
                            results: data
                        };
                    },
                    cache: true
                },
                //templateResult返回结果回调function formatRepo(repo){return repo.text},
                // 这样就可以将返回结果的的text显示到下拉框里
                templateResult: formatCate,
                //templateSelection选中项回调function formatRepoSelection(repo){return repo.text}
                templateSelection: formatCateSelection,
                ////escapeMarkup字符转义处理,这里不处理
                escapeMarkup: function (markup) { return markup; }

            });
            //格式化获取的分类数据显示到下拉框
            function formatCate (cate) {
                return "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" +
                // 对于单选来说，必须在select的第一个位置设置一个空的option选项，
                // placeholder才会起作用，否则浏览器会去选择第一个值。而多选是不能有空的option的。
                //所以这里安排一个占位,不会填到数据里面的
                cate.name? cate.name : "默认分类"   +
                    "</div></div></div>";
            }
            //格式化选择后的数据,显示到选择框
            function formatCateSelection (cate) {
                //select2默认的数据属性是id、text，服务端返回的json数据最好直接包含id 和 text
                //新增的本地数据格式是{'id':'','text':'xxx'}
                //服务端的格式是{'id':'','name':''}
                return cate.name || cate.text;
            }

            //最终所有选择的数据会添加到select name='cates[]'的cates[]数组中,服务端的会是id 本地新增的是string
            //在服务端加以区别


        });








    </script>

@endsection
