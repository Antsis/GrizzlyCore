<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SendCodeController extends Controller
{
    /**
     * 发送验证码
     * author wcz
     * 
     */
    public function sendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'string|regex:/^1(3|4|5|6|7|8|9)\d{9}$/',
        ]);
        //生成随机码
        $smsCode = "";
        for($i=0;$i<6;$i++){
            $smsCode .= mt_rand(0, 9);
        }
        //

    }
}
