<?php

namespace App\Http\Controllers;

use App\Services\SendCodeService;
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
        if ($validator->fails()) {
            return $this->fail($validator->errors()->all());
        }
        $phone = $request->input('phone');
        //生成随机码
        $code = "";
        for($i=0;$i<6;$i++){
            $code .= mt_rand(0, 9);
        }
        // 调用短信服务
        $bool = SendCodeService::sendCode($phone, $code);
        if (!$bool) {
            return $this->fail('短信发送失败');
        }
        
        // 存储数据
        $expired = date('Y-m-d H:i:s', time() + 600);
        $bool = SendCodeService::store($phone, $code, $expired);
        if (!$bool) {
            return $this->fail('服务器存储失败');
        }
        return $this->success('验证码发送成功');
    }
}
