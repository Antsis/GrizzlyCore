<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\RegisterService;
use Error;

class RegisterController extends Controller
{
    /**
     * 注册接口
     * author wcz
     */
    public function register(Request $request)
    {
        date_default_timezone_set('PRC');
        dd(date('Y-m-d H:i:s'));

        $validator = Validator::make($request->all(), [
            'phone' => 'string|regex:/^1(3|4|5|6|7|8|9)\d{9}$/',
            'email' => 'string|email|required_without:phone',
            'password' => 'string|min:6|max:50',
            'code' => 'string|min:6|max:6',
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors()->all());
        }
        $passwd = $request->input('password');
        // TODO: 判断密码的复杂程度
        // 判断是否为手机号, 且邮箱不存在
        if ($request->has('phone') && !$request->has('email')) {
            $result = RegisterService::phoneInsert($request->input('phone'), $passwd);
        }else{
            goto Error;
        }
        $result = RegisterService::emailInsert($request->input('email'), $passwd);

        dd();
        if ($result) {
            return $this->success($result);
        }else {
            goto Error;
        }
        Error:
            return $this->fail('参数错误');
        
    }
}
