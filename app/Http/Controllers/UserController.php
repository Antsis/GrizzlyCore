<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * 获取验证码图片
     * Show the form for creating a new resource.
     *
     * @return Image 输出图片
     */
    public function create()
    {
        header('Content-type: image/png');
        $captcha = new Captcha();
        imagepng($captcha->image);
        return response(imagepng($captcha->image))->header('Content-type', 'image/png');
    }

    /**
     * 注册功能
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->has('step')){
            return response()->json(["error"=>['code'=>'001','message'=>'step is null!']]);
        }
        if($request->input('step')){
            // 注册步骤1
            // 表单验证
            if(!$request->has('code')){
                return response()->json(["error"=>['code'=>'001','message'=>'code is empty!']]);
            }
            if(!$request->has('phone_email')){
                return response()->json(["error"=>['code'=>'002','message'=>'email is empty!']]);
            }

            $code = strtolower($request->input('code'));
            $phoneEmail = $request->input('phone_email');
            //判断session验证码
            if(!session()->has('verify_code')){
                return response()->json(["error"=>['code'=>'003','message'=>'verify code is empty!']]);
            }

            if($code!=session()->get('verify_code')){
                return response()->json(["error"=>['code'=>'004','message'=>'The code is incorrect!']]);
            }
            if($this->cehckUserIs($phoneEmail)){
                return response()->json(["error"=>['code'=>'005','message'=>'user already exists!']]);
            }
    
            // 手机正则表达式 手机对应的操作
            if(preg_match('/^1[3-9]\d{9}$/', $phoneEmail)){
                session()->put('phone', $phoneEmail);
                session()->put('reg_state', '1');
                if($this->sendCodeSms()){
                    return response()->json(["success"=>['code'=>'101','message'=>'success send phone code!', 'text'=>$phoneEmail]]);
                }else{
                    return response()->json(["error"=>['code'=>'006','message'=>'server is error!']]);
                };

                // 邮箱正则表达式 邮箱对应的操作
            }else if(preg_match('/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/', $phoneEmail)){
                session()->put('email', $phoneEmail);
                session()->put('reg_state', '0');
                if($this->sendCodeEmail()){
                    return response()->json(["success"=>['code'=>'102','message'=>'success send email code!', 'text'=>$phoneEmail]]);
                }else{
                    return response()->json(["error"=>['code'=>'007','message'=>'server is error!']]);
                };
                // 如果匹配到@符号 则返回相应的消息
            }else if(preg_match('/@/', $phoneEmail)){
                return response()->json(["error"=>['code'=>'008','message'=>'Incorrect email format!']]);
            }else{
                return response()->json(["error"=>['code'=>'009','message'=>'Incorrect phone format!']]);
            }

        }else{
        // 注册步骤2
            if(!$request->has('code')){
                return response()->json(["error"=>['code'=>'001','message'=>'code is null!']]);
            }
            if(!$request->has('password')){
                return response()->json(["error"=>['code'=>'002','message'=>'password is null!']]);
            }
            $code = $request->input('code');
            $p = $request->input('password');
            // 密码复杂的正则表达验证
            if(!((strlen($p)>7&&strlen($p)<21)&&((preg_match('/\d/', $p)&&preg_match('/[a-zA-Z]/', $p))||(preg_match('/[a-zA-Z]/', $p)&&preg_match('/\W/', $p))||(preg_match('/\d/', $p)&&preg_match('/\W/', $p))))){
                return response()->json(["error"=>['code'=>'003','message'=>'The password is too simple!']]);
            }
            if(!session()->has('reg_state')){
                return response()->json(["error"=>['code'=>'009','message'=>'session reg_state is too simple!']]);
            }
            // reg_state 为1 的话是手机, 0的话是邮箱
            if(session()->get('reg_state')){
                if(!session()->has('sms_code')||!session()->has('phone')){
                    return response()->json(["error"=>['code'=>'004','message'=>'sms_code or phone is empty!']]);
                }
                if($code!=session()->get('sms_code')){
                    return response()->json(["error"=>['code'=>'005','message'=>'The verification code is incorrect!']]);
                }
                $phone = session()->get('phone');
                $state = $this->regCreatePhone($phone, $p);
                if($state!=0){
                        $array = User::find($state)->toArray();
                        session()->put('logined', $array);
                        return response()->json(["success"=>['code'=>'101','message'=>'Success login!(Phone)', 'avatar_url'=>$array['avatar_url']]]);
                }else{
                    return response()->json(["error"=>['code'=>'006','message'=>'Server is incorrect!']]);
                }
            }else{
                if(!session()->has('email_code')||!session()->has('email')){
                    return response()->json(["error"=>['code'=>'007','message'=>'The verification code is incorrect!!']]);
                }
                if($code!=session()->get('email_code')){
                    return response()->json(["error"=>['code'=>'008','message'=>'The verification code is incorrect!!']]);
                }
                $email = session()->get('email');
                $state = $this->regCreateEmail($email, $p);
                if($state!=0){
                    $array = User::find($state)->toArray();
                    session()->put('logined', $array);
                    return response()->json(["success"=>['code'=>'102','message'=>'Success login!(Email)', 'avatar_url'=>$array['avatar_url']]]);
                }else{ 
                    return response()->json(["error"=>['code'=>'009','message'=>'Server is incorrect!']]);
                };
            }
        }
        
    }

    /**
     * 
     * 登录功能
     * 
     */
    public function login()
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }


    /**
     * 验证码动态验证
     */
    public function checkCode(Request $request)
    {
        if(empty($request->input('code'))){
            return response()->json(["error"=>['code'=>'001','message'=>'code is empty!']]);
        }
        $code = strtolower($request->input('code'));
        if(!session()->has('verify_code')){
            return response()->json(["error"=>['code'=>'002','message'=>'session-verify_code is empty!']]);
        }
        if($code==session('verify_code')){
            return response()->json(["success"=>['code'=>'101','message'=>'code is true!']]);
        }

        return response()->json(["error"=>['code'=>'003','message'=>'code is error!']]);
    }

    /**
     * 检查用户是否存在
     * @param string 用户登录名
     * @return true|false
     */
    public function cehckUserIs($login)
    {
        $web = User::where('phone', $login)
                ->orWhere('email', $login)
                ->orWhere('username', $login)
                ->first();
        if($web){
            return 1;
        }
        return 0;
    }

    /**
     * 发送验证码
     */
    public function sendCodeSmsEmail()
    {
        if(session()->get('reg_state')){
            $this->sendCodeSms();
        }else{
            $this->sendCodeEmail();
        }
    }

    /**
     * 这里调用了PHPMailer发送邮件
     * @return true|false 返回是否成功
     */
    public function sendCodeEmail()
    {
        //此类涉及个人账户
        $sm = new SendEmail();
        $res = $sm->sendCodeEmail(session()->get('email'));
        if($res==0){
            return 1;
        }
        return 0;
    }
    /**
     * 这里是调用阿里云的短信服务
     * @return true|false 返回是否成功
     */
    public function sendCodeSms()
    {
        //此类涉及个人账户
        $sm = new SendSms();
        $res = $sm->sendCodeSms(session()->get('phone'));
        if($res==0){
            return 1;
        }
        return 0;
    }

     /**
     * 在数据库中创建用户
     * @param string $phone 电话号码
     * @param string $passwd 账号密码
     * @return integer|false
     */

    protected function regCreatePhone($phone, $passwd)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $username = "";
        for ($i = 0; $i < 6; $i++ ){
            $username .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        $username .= $phone;

        $user = new User;
        $user->username = $username;
        $user->password = bcrypt($passwd);
        $user->phone = $phone;
        $app_url = env('APP_URL');
        $user->avatar_url = $app_url."/avatar/default";
        if($user->save()){
            return $user->id;
        }
        
        return 0;
    }

    /**
     * 在数据库中创建用户
     * @param string $email 邮箱
     * @param string $passwd 账号密码
     * @return integer|false
     */
    protected function regCreateEmail($email, $passwd)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $username = "";
        for ($i = 0; $i < 6; $i++ ){
            $username .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        $str = explode("@", $email);
        $username .= $str[0];

        $user = new User;
        $user->username = $username;
        $user->password = bcrypt($passwd);
        $user->email = $email;
        $avatar_url = md5(strtolower(trim($email)));
        $user->avatar_url = "https://www.gravatar.com/avatar/$avatar_url";
        if($user->save()){
            return $user->id;
        }
        return 0;
    }
}
