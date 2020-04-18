<?php

namespace App\Http\Controllers;

use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\New_;

class UserController extends Controller
{
    protected $user;
    protected $role;

    /**
     * UserController constructor.
     *
     * @param $user
     */
    public function __construct(UserRepository $user,RoleRepository $role ) {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * 列表页,有日期范围
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //日期范围,用于前端时间插件初始化
        $dateData = ['datemin' => date('Y-m-d'), 'datemax' => date('Y-m-d')];
        return view('admin.user.index', $dateData);
    }

    /**
     * 列表页数据
     * ajax请求list,搜索,排序
     */
    public function list(Request $request) {
        //根据关键词和要匹配的字段返回用户
        $data = (new User())->search($request,'name');
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

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
        $user = $this->user->getById($id);
        return view('admin.user.center',compact('user'));
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
        $user = $this->user->getById($id);
        return view('admin.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

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
        User::destroy($id);
        return response()->json(['status'=>'200','msg'=>'角色分配成功']);
    }

    /**
     * 展示分配角色页
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roleShow($id) {
        $user = $this->user->getById($id);
        $roles = $this->role->getAll();
        return view('admin.user.role',compact('user','roles'));
    }

    public function roleSave(Request $request,$id) {
        $user = $this->user->getById($id);
        $user->role_id = $request->get('rid');

        $user->save();

        return response()->json(['status'=>'200','msg'=>'角色分配成功']);

    }
}
