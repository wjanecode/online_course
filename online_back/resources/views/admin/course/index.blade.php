@extends('layouts.main')

@section('content')
    <div class="text-c">
        <input type="text" name="" id="" placeholder="栏目名称、id" style="width:250px" class="input-text">
        <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
		<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
		<a class="btn btn-primary radius" onclick="system_category_add('添加分类','{{ url('/course/create') }}')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加栏目</a>
		</span>
        <span class="r">共有数据：<strong>{{ $data->count() }}</strong> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="80">ID</th>
                <th>课程名称</th>
                <th>封面</th>
                <th>课程节数</th>
                <th>讲师</th>
                <th width="100">学生</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $key => $course)
                <tr class="text-c">
                    <td><input type="checkbox" name="" value=""></td>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td ><img width="100" height="100" src="{{ url($course->cover) }}" alt="课程封面"></td>
                    <td>{{ $course->lessons_count }}</td>

                    <td>{{ $course->teacher($course->teacher_id)->name }}</td>
                    <td>{{ $course->students_count }}</td>
                    <td class="f-14"><a title="编辑" href="javascript:;" onclick="system_category_edit('分类编辑','{{ url("/course/".$course->id."/edit") }}','1','700','480')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a title="删除" href="javascript:;" onclick="system_category_del(this,{{ $course->id }})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
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
                    url: "{{ url('course') }}" +'/'+id,
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
