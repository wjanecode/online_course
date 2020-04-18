<?php

namespace App\Http\Controllers;

use App\Category;
use App\Course;
use App\Http\Requests\CourseStoreRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\CourseRepository;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Array_;
use function foo\func;

class CourseController extends Controller
{
    protected $courseRepository;
    protected $categoryRepository;
    /**
     * CourseController constructor.
     */
    public function __construct(CourseRepository $course_repository,CategoryRepository $category_repository) {
        //依赖注入仓库类
        $this->courseRepository = $course_repository;
        $this->categoryRepository = $category_repository;
    }


    /**
     * 课程列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //获取课程列表
        $data = $this->courseRepository->getList(10);
        //dd($courses);
        //返回视图
        return view('admin.course.index',compact('data'));

    }

    /**
     * 添加课程展示视图
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cate = $this->categoryRepository->get();
        //dd($data);

        return view('admin.course.create',compact('cate'));

    }

    /**
     * 课程入库操作
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseStoreRequest $request)
    {
        //
        //dd($request);
        //创建course
        $course = $this->courseRepository->save($request);
        //cate分类处理,先转成全是id的数组,并保存cate
        $cates = $this->normalizeCate($request->get('cates'));
        //保存cates到cate_course关联表,使用同步sync()
        $course->cate()->sync($cates);

        return response()->json(['status'=>'201','msg'=>'课程创建成功']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $course = $this->courseRepository->get($id);
        return view('admin.course.edit',compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseStoreRequest $request, $id)
    {
        //更新课程
        $course = $this->courseRepository->update($request,$id);
        //cate分类处理,先转成全是id的数组,并保存cate
        $cates = $this->normalizeCate($request->get('cates'));
        //保存cates到cate_course关联表,使用同步sync()
        $course->cate()->sync($cates);

        return response()->json(['status'=>'201','msg'=>'课程更新成功']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Course::destroy($id);
        return response()->json(['status'=>'200','msg'=>'删除成功']);
    }

    /**
     * 正常化select2上传的cates[]数组
     * @param array $cates
     *
     * @return array|\Illuminate\Support\Collection
     */
    public function normalizeCate( Array $cates ) {
        //cates是数组,包含已存在的分类的id 和 新的分类名称
        //遍历cates,已存在的就不变,新的入库,并返回id,组成新的数组
        $cates = collect($cates)->map(function ($item){

            if (is_numeric($item)){
                return $item;
            }else{
                return $this->categoryRepository->saveReturnId($item);
            }
        });

        return $cates;

    }
}
