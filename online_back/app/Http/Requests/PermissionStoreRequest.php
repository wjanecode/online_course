<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionStoreRequest extends FormRequest
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
            //
            'name'=> 'required',
            'routename' => 'required',
            'pid'  => 'required',
        ];
    }

    public function messages(  ) {
        return [
            'name.required' => '权限名称不能为空',
            'routename.required' => '权限名称不能为空',
            'pid.required' => '权限名称不能为空'
        ];
    }
}
