<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\UserRepository;


/**
 * App\Course
 *
 * @property int $id
 * @property string $name
 * @property string|null $cover
 * @property string|null $description
 * @property int $lessons_count
 * @property float $price
 * @property int $duration
 * @property int $teacher_id
 * @property int $students_count
 * @property string $is_hidden
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereIsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereLessonsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereStudentsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Course extends Model
{
    //
    protected $fillable=[
        'name','cover','description','price','teacher_id'
    ];


    /**
     * 获取teacher,其实是用户的一员
     * @param $id
     *
     * @return User|User[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function teacher($id) {
        return User::find($id);
    }

    /**
     * 关联cate表,多对多
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cate(  ) {
        return $this->belongsToMany(Category::class,'cate_course','course_id','cate_id');
    }







}
