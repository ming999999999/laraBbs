<?php

namespace App\Http\Requests\Api;

// use Illuminate\Foundation\Http\FormRequest;
use Dingo\Api\Http\FormRequest;

class VerificationCodeRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [
            // 'phone' => 'required|regex:/^1[34578]\d{9}$/|unique:users',

            'captcha_key'=>'required|string',
            'captcha_code'=>'required|string',
        ];
    }

    public function attributes()
    {

        return [

            'captcha_key'=>'图片验证码key',
            'captcha_code'=>'图片验证码',
            
        ];
    }
}
