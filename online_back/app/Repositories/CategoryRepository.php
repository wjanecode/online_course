<?php
/**
 *
 * @author woojuan
 * @email woojuan163@163.com
 * @copyright GPL
 * @version
 */

namespace App\Repositories;

use App\Category;

class CategoryRepository {

    /**
     * 返回所有分类数据
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get(){
        return Category::all();
    }

    /**
     * 根据id获取具体分类
     * @param $id
     *
     * @return Category|Category[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getById($id) {
        return Category::find($id);
    }

    /**
     * 传入数组创建资源,成功返回模型实例,失败返回false
     * @param array $arr
     *
     * @return Category|\Illuminate\Database\Eloquent\Model
     */
    public function save($request){
        //创建资源,成功返回模型实例,失败返回false


        return Category::create(['name'=>$request->get('cate_name')]);
    }

    /**
     * 更新分类
     * @param $request
     * @param $id
     *
     * @return bool
     */
    public function update($request,$id  ) {
        $cate = Category::find($id);
        $cate->name = $request->get('cate_name');
        return $cate->save();
    }

    /**
     * 删除分类
     * @param $id
     *
     * @return int
     */
    public function destroy($id ) {
        return Category::destroy($id);
    }

    public function getByKeyword($request  ) {
        //模糊查询,返回数组
        return Category::select(['id','name'])->where('name','like','%'.$request->get('keyword').'%')->get();
    }

    public function saveReturnId( $name ) {
        $cate = Category::create(['name' => $name]);
        return $cate->id;
    }

}
