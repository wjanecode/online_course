<?php
/**
 *
 * @author woojuan
 * @email woojuan163@163.com
 * @copyright GPL
 * @version
 */

namespace App\Repositories;
use App\Course;
use App\Http\Requests\CourseStoreRequest;


class CourseRepository {

    /**
     * 按分页获取课程
     * @param $num
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function getList($num){
        //调用分页函数,仅包含上一页和下一页,返回分页器结果
        //直接返回也会转化为json
        return Course::with('cate')->simplePaginate($num);
    }

    /**
     * 保存课程
     * @param CourseStoreRequest $request
     *
     * @return Course|\Illuminate\Database\Eloquent\Model
     */
    public function save(CourseStoreRequest $request ) {
        $data = [
            'name'  =>  trim($request->get('course_name')),
            'cover' =>  $request->get('tmp_image') ?  $request->get('tmp_image') : '/images/default.png' ,
            'description' => trim($request->get('description')),
        ];

        return Course::create($data);
    }


    /**
     * 获取单独课程
     * @param $id
     *
     * @return Course|Course[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function get( $id ) {
        return Course::with('cate')->find($id);
    }

    /**
     * 更新课程
     */
    public function update(CourseStoreRequest $request ,int $id ) {
        $course = $this->get($id);
        $course->name = trim($request->get('course_name'));
        $course->cover = $request->get('tmp_image') ?  $request->get('tmp_image') : '/images/default.png';
        $course->description = trim($request->get('description'));
        $course->save();

        return $course;
    }
}
