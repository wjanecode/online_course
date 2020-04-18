@extends('layouts.main')
@section('header')
    <style>
        td {
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="text-c"> 日期范围：
        <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
        -
        <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
        <input type="text" class="input-text" style="width:250px" placeholder="输入用户名称" id="kw" name="">
        <button type="submit" class="btn btn-success" id="searchbtn" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"> <a href="javascript:;" onclick="admin_add('添加管理员','admin-add.html','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a></span> <span class="r">共有数据：<strong></strong> 条</span> </div>
    <table class="table table-border table-bordered table-bg table-sort" style="text-align: center" >
        <thead>
        <tr>
            <th scope="col" colspan="9">员工列表</th>
        </tr>
        <tr class="text-c">
            <th width="25"><input type="checkbox" name="" value=""></th>
            <th width="40">ID</th>
            <th width="100">登录名</th>
            <th width="100">头像</th>
            <th width="150">邮箱</th>
            <th width="150">角色</th>
            <th width="130">加入时间</th>
            <th width="100">是否已启用</th>
            <th width="150">操作</th>
        </tr>
        </thead>
        <tbody>
        {{--@foreach($data as $item)--}}
        {{--<tr class="text-c">--}}
        {{--<td><input type="checkbox" value="{{ $item->id }}" name="ids[]"></td>--}}
        {{--<td>{{ $item->id }}</td>--}}
        {{--<td><u style="cursor:pointer" class="text-primary" onclick="member_show('{{ $item->username }}','member-show.html','10001','360','400')">{{ $item->username }}</u></td>--}}
        {{--<td>{{ $item->created_at }}</td>--}}
        {{--<td class="td-status"><span class="label label-success radius">已启用</span></td>--}}
        {{--<td class="td-manage">--}}
        {{--修改 和 删除--}}
        {{--<a style="text-decoration:none" onClick="member_stop(this,'10001')" href="javascript:;" title="停用">--}}
        {{--<i class="Hui-iconfont">&#xe631;</i></a> <a title="编辑" href="javascript:;" onclick="member_edit('编辑','member-add' +--}}
        {{--'.html','4','','510')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <--}}
        {{--a style="text-decoration:none" class="ml-5" onClick="change_password('修改密码','change-password.html','10001','600','--}}
        {{--270')" href="javascript:;" title="修改密码"><i class="Hui-iconfont">&#xe63f;</i></a> <a title="删除" href="javascript:--}}
        {{--;" onclick="member_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>--}}
        {{--</td>--}}
        {{--</tr>--}}
        {{--@endforeach--}}
        </tbody>
    </table>



@endsection

@section('js')
    <script>

        $(document).ready(function () {
            // datatables初始化
            var datatable = $('.table-sort').dataTable({
                // 以第2列为初始排序
                order: [[1, 'desc']],
                // 设置 第1列和最后一列不排序
                columnDefs: [
                    // 第1列和第10列不排序 因为索引是从0开始
                    {targets: [0, 5], orderable: false}
                ],
                // 下拉分页数
                lengthMenu: [3, 5, 7, 10],
                // 客户搜索隐藏
                searching: false,
                // 在ajax请求数据量给客户的一个提示
                processing: true,
                // 开启服务器模式
                serverSide: true,
                // ajax发起请求
                ajax: {
                    // 请求地址
                    url: '{{ route("user.list") }}',
                    // 请求方式 get/post
                    type: 'POST',
                    // 请求的参数
                    // 两者写法效果一致  但是它用于搜索
                    // 如果只有一个参数的时候，可以不写小括号
                    data: d => {
                        d.datemin = $('#datemin').val();
                        d.datemax = $('#datemax').val();
                        d.kw = $.trim($('#kw').val());
                        d._token = '{{ csrf_token() }}';
                    }
                },
                // 规则每列是如何来显示
                //用于查询数据库的字段
                columns: [
                    {data: 'aaa', defaultContent: '', className: "text-c"},//勾选栏
                    {data: 'id'},//ID
                    {data: 'name'},//用户名
                    {data: 'avatar'},//头像地址
                    {data: 'email'},//邮箱
                    {data: 'role'},//角色
                    {data: 'created_at'},//创建时间
                    {data: 'status', className: "text-c"},
                    {data: 'bbb', defaultContent: '删除 和  修改'}
                ],
                //规则每列是如何来显示
                // row 当前行的dom对象  jquery对象$(row)
                // data 当前的数据
                // dataIndex当前数据的索引
                createdRow(row, data) {
                    // 全选复选框
                    var html = `<input type="checkbox" value="${data.id}" name="ids[]" />`;
                    $(row).find('td:eq(0)').html(html);

                    //头像显示
                    //特别注意html是用``包含的,而不是'',''里面data不解析
                    var html = `<img src="${data.avatar}" width="60%"/>`
                    $(row).find('td:eq(3)').html(html);
                    console.log(data.avatar)

                    //角色显示
                    $(row).find('td:eq(5)').text(data.role.name);
                    console.log(data.role.name);//角色名称

                    // 用户是否禁用
                    var html = `<span data-id="${data.id}" class="label label-success radius">成功</span>`;
                    if (data.status != 'T') {// 被禁用
                        html = `<span data-id="${data.id}" class="label label-warning radius">警告</span>`;
                    }
                    $(row).find('td:eq(7)').html(html);

                    // 操作
                    var html = `<div class="btn-group">
                                  <a href="javascript:void(0);" onclick="admin_add('分配角色','/user/role/${data.id}')" class="btn size-S btn-primary-outline radius">分配角色</a>
                                  <a href="javascript:void(0);" onclick="admin_edit('用户信息','/user/${data.id}/edit/')"class="btn size-S btn-primary-outline radius">修改</a>
                                  <a href="javascript:void(0);"  onclick="admin_del(this,${data.id})" class="btn size-S btn-danger-outline radius delbtn">删除</a>
                                </div>`;
                    $(row).find('td:eq(8)').html(html);
                }
            });

            // 点击搜索让datatable加载一次
            $('#searchbtn').click(() => {
                datatable.api().ajax.reload();
            });

            // 给删除添加事件  委托
            $('.table-sort').on('click', '#delbtn', function (evt) {
                // 阻止默认事件
                evt.preventDefault();
                var url = $(this).attr('href');

                $.ajax({
                    url,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    success: ret => {
                        $(this).parents('tr').remove();
                        layer.msg('删除成功',{time:2000,icon:6});
                    }
                });

                //return false;
            });

        })
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
        /*管理员-删除*/
        function admin_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type: 'DELETE',
                    url: '/user/'+id,
                    dataType: 'json',
                    data:{
                      _token:'{{ csrf_token() }}'
                    },
                    success: function(data){
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    },
                    error:function(data) {
                        console.log(data.msg);
                    },
                });
            });
        }

        /*管理员-编辑*/
        function admin_edit(title,url,id,w,h){
            layer_show(title,url,w,h);
        }
        /*管理员-停用*/
        function admin_stop(obj,id){
            layer.confirm('确认要停用吗？',function(index){
                //此处请求后台程序，下方是成功后的前台处理……
                $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,id)" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
                $(obj).remove();
                layer.msg('已停用!',{icon: 5,time:1000});
            });
        }

        /*管理员-启用*/
        function admin_start(obj,id){
            layer.confirm('确认要启用吗？',function(index){
                //此处请求后台程序，下方是成功后的前台处理……

                $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,id)" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
                $(obj).remove();
                layer.msg('已启用!', {icon: 6,time:1000});
            });
        }



    </script>
@endsection
