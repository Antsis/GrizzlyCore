<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * 生成token
     *
     * @param array $date
     * @return string 
     *
     */
    public function getToken(Array $data)
    {
        $date = json_encode($data);
        $token = Crypt::encryptString($data);
    }

    /**
     * 登录
     * 
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'string|regex:/^1(3|4|5|6|7|8|9)\d{9}$/',
            'email' => 'string|email|required_without:phone',
            'password' => 'string|min:6|max:50',
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->all());
        }

    }
}
