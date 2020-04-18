<?php

namespace App\Http\Controllers;

use App\Http\Requests\CateStoreRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $cate;

    /**
     * CategoryController constructor.
     *
     * @param $cate
     */
    public function __construct( CategoryRepository $cate ) {
        $this->cate = $cate;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //获取全部分类
        $data = $this->cate->get();
        //返回分类列表页
        return view('admin.cate.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //返回创建分类列表页
        return view('admin.cate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CateStoreRequest $request)
    {
        //创建资源
        //dd($request);
        if($this->cate->save($request)){
            //返回结果
            return response()->json(['status'=>201,'msg'=>'分类创建成功']);
        }

        //失败返回结果
        return response()->json(['status'=>0,'msg'=>'分类创建失败']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //返回编辑分类页
        $data = $this->cate->getById($id);

        return view('admin.cate.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CateStoreRequest $request, $id)
    {
        //更新分类
        if ($this->cate->update($request,$id)){
            //成功返回
            return response()->json(['status'=>200,'msg'=>'修改成功']);
        }

        //失败返回
        return response()->json(['status'=>0,'msg'=>'分类修改失败']);

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
        if ($this->cate->destroy($id)){
            //删除成功
            return response()->json(['status'=>200,'msg'=>'修改成功']);
        }
        //删除失败
        return response()->json(['status'=>0,'msg'=>'分类修改失败']);
    }

    /**
     * 查询分类
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiGet(Request $request  ) {
        //api获取分类信息
        //keyword,查询参数

        $cates = $this->cate->getByKeyword($request);
        return response()->json($cates);
    }
}
