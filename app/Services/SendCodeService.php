<?php

namespace App\Services;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Illuminate\Support\Facades\DB;

class SendCodeService
{
    /**
     * 验证码存储到数据库
     *
     * @param string $phone|手机号
     * @param string $code|验证码
     * @param string $expired|有效时间
     * @return bool
     */
    public static function store(string $phone, string $code, string $expired)
    {
        $bool = DB::table('codes')
                        ->insert([
                            'phone' => $phone,
                            'code' => $code,
                            'expired' => $expired,
                        ]);
        return $bool;
    }

    /**
     * 调用阿里云发送短信
     * 
     * @param string $phone
     * @param string $code
     * @return bool
     */
    public static function sendCode(string $phone, string $code)
    {
        // session()->put('sms_code', $smsCode);
        AlibabaCloud::accessKeyClient(env('ALIYUN_SMS_KEY'), env('ALIYUN_SMS_VALUE'))
                        ->regionId('cn-hangzhou')
                        ->asDefaultClient();
        try {
            AlibabaCloud::rpc()
                    ->product('Dysmsapi')
                    // ->scheme('https') // https | http
                    ->version('2017-05-25')
                    ->action('SendSms')
                    ->method('POST')
                    ->host('dysmsapi.aliyuncs.com')
                    ->options([
                        'query' => [
                            'RegionId' => "cn-hangzhou",
                            'PhoneNumbers' => $phone,
                            'SignName' => "Grizzly官网",
                            'TemplateCode' => "SMS_187271356",
                            'TemplateParam' => "{\"code\":$code}",
                        ],
                    ])
                    ->request();
        } catch (ClientException $e) {
            // echo $e->getErrorMessage() . PHP_EOL;
            return false;
        } catch (ServerException $e) {
            // echo $e->getErrorMessage() . PHP_EOL;
            return false;
        }
        return true;
    }

    /**
     * 查询手机验证码
     *
     * @param string $phone
     * @param string $code
     * @param string expired
     * @return object
     */
    public static function getCode(string $phone, string $code)
    {
        $now = date('Y-m-d H:i:s');
        $result = DB::table('codes')
                        ->select(
                            'phone',
                            'code',
                        )
                        ->where('phone', '=', $phone)
                        ->where('code', '=', $code)
                        ->where('expired', '<=', $now)
                        ->orderBy('id', 'desc')
                        ->first();
        return $result;
    }
}