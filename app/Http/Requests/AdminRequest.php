<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator;
use App\Models\Admin;

class AdminRequest extends FormRequest
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
        $this->advRules();
        return [
            'phone'=>'required|checkPhone',
            'username'=>'required|unique:admins,username',
            'truename'=>'required|',
            'email'=>'required|email',
            'password'=>'required|confirmed',
            'role_id'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'phone.check_phone'=>'手机号格式不正确',
            'role_id.required'=>'角色必须选择一个'

        ];
    }

    private function advRules()
    {
        // 手机号码
        Validator::extend('checkPhone', function ($attribute, $value, $parameters, $validator) {
            $reg = '/^1[3-9]\d{9}$/';
            return preg_match($reg, $value);
        });
     }
}
