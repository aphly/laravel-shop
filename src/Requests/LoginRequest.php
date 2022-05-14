<?php

namespace Aphly\LaravelShop\Requests;

use Aphly\Laravel\Requests\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{

    public function rules()
    {
        if($this->isMethod('post')){
            return [
                'identifier' => ['required'],
                'credential' => 'required|between:6,64|alpha_num',
            ];
        }
        return [];
    }

//    public function attributes()
//    {
//        return [
//            'username'      => '用户名',
//            'password'      => '密码',
//        ];
//    }

    public function messages()
    {
        return [
            'identifier.required' => '请输入email',
            'credential.required' => '请输入密码',
        ];
    }


}
