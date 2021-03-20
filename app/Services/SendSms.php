<?php

namespace App\Http\Controllers;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class SendSms
{
    public function sendCodeSms($phone)
    {
        $smsCode = "";
        for($i=0;$i<6;$i++){
            $smsCode .= mt_rand(0, 9);
        }

        
        
        session()->put('sms_code', $smsCode);


        AlibabaCloud::accessKeyClient('LTAI4Fvn8AzD6hjEzDUhePaR', 'V8h6qaXdndO0gGxyfqCVivDARo61kr')
                        ->regionId('cn-hangzhou')
                        ->asDefaultClient();
        
        try {
            $result = AlibabaCloud::rpc()
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
                                                    'TemplateParam' => "{\"code\":$smsCode}",
                                                ],
                                            ])
                                    ->request();
            return 0;
            // print_r($result->toArray());
        } catch (ClientException $e) {
            // echo $e->getErrorMessage() . PHP_EOL;
            return 1;
        } catch (ServerException $e) {
            // echo $e->getErrorMessage() . PHP_EOL;
            return 2;
        }
    }
}

