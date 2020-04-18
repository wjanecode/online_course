<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //课程名称
            'course_name' => 'required|min:2|max:50',

            //简介
            //'description' => 'required'
        ];
    }

    public function messages(  ) {
        return [
           'course_name.required' => '课程名称不能为空',
           'course_name.min' => '课程名称不能少于两个字符',
           'course_name.max' => '课程名称不能大于50个字符',



            //'description.required' => '简介不能为空',
        ];
    }
}
