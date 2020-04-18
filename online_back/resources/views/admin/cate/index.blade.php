@extends('layouts.main')

@section('content')
    <div class="text-c">
        <input type="text" name="" id="" placeholder="栏目名称、id" style="width:250px" class="input-text">
        <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
		<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
		<a class="btn btn-primary radius" onclick="system_category_add('添加分类','{{ url('/cate/create') }}')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加栏目</a>
		</span>
        <span class="r">共有数据：<strong>{{ $data->count() }}</strong> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="80">ID</th>
                <th width="80">排序</th>
                <th>分类名称</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $key => $cate)
            <tr class="text-c">
                <td><input type="checkbox" name="" value=""></td>
                <td>{{ $cate->id }}</td>
                <td>{{ $key }}</td>
                <td class="text-l">{{$cate->name}}</td>
                <td class="f-14"><a title="编辑" href="javascript:;" onclick="system_category_edit('分类编辑','{{ url("/cate/".$cate->id."/edit") }}','1','700','480')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                    <a title="删除" href="javascript:;" onclick="system_category_del(this,{{ $cate->id }})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('js')
    <script>
        // $('.table-sort').dataTable({
        //     "aaSorting": [[ 1, "desc" ]],//默认第几个排序
        //     "bStateSave": true,//状态保存
        //     "aoColumnDefs": [
        //         //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
        //         {"orderable":false,"aTargets":[0,4]}// 制定列不参与排序
        //     ]
        // });
        /*系统-栏目-添加*/
        function system_category_add(title,url,w,h){
            layer_show(title,url,w,h);
        }
        /*系统-栏目-编辑*/
        function system_category_edit(title,url,id,w,h){
            layer_show(title,url,w,h);
        }
        /*系统-栏目-删除*/
        function system_category_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type: 'DELETE',
                    url: "{{ url('cate') }}" +'/'+id,
                    data:{
                        '_token': "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: function(response){
                        if (response.status !== 0){
                            $(obj).parents("tr").remove();
                            layer.msg('已删除!',{icon:1,time:1000});
                        }
                    },
                    error:function(response) {
                        console.log(response.msg);
                    },
                });
            });
        }
    </script>
@endsection
