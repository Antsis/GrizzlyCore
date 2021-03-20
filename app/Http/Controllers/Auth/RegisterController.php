<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * 登录接口
     * author wcz
     */
    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'phone' => 'string|regex:/^1(3|4|5|6|7|8|9)\d{9}$/',
            'email' => 'string|email',
            'password' => 'string|min:6|max:50',
        ])
        if($validator->fails()){
            return 
        }
    }
}
