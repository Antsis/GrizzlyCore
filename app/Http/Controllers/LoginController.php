<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\SendEmail;
use App\Http\Controllers\sendSms;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Exception;

class LoginController extends Controller
{
    /**
     * 
     * 验证码图片
     *
     * @return 输出图片
     */
    public function verify()
    {     
        $captcha = new Captcha();
        // $code = $captcha->captcha();
        // session()->put('verify_code', $code);
        $captcha->captcha();
    }
    /**
     * 验证码动态监测
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
        }else{
            return response()->json(["error"=>['code'=>'003','message'=>'code is error!']]);
        }
    }

    /**
     * 注册请求
     */
    public function register(Request $request)
    {   
        if(!$request->has('code')){
            return response()->json(["error"=>['code'=>'001','message'=>'code is empty!']]);
        }
        if(!$request->has('phone_email')){
            return response()->json(["error"=>['code'=>'002','message'=>'email is empty!']]);
        }

        $code = strtolower($request->input('code'));
        $phoneEmail = $request->input('phone_email');

        if(!session()->has('verify_code')){
            return response()->json(["error"=>['code'=>'003','message'=>'verify code is empty!']]);
        }
        if($code!=session()->get('verify_code')){
            return response()->json(["error"=>['code'=>'004','message'=>'The code is incorrect!']]);
        }
        if($this->cehckUserIs($phoneEmail)){
            return response()->json(["error"=>['code'=>'005','message'=>'user already exists!']]);
        }

        if(preg_match('/^1[3-9]\d{9}$/', $phoneEmail)){
            session()->put('phone', $phoneEmail);
            session()->put('reg_state', '1');
            if($this->sendCodeSms()){
                return response()->json(["success"=>['code'=>'101','message'=>'success send phone code!', 'text'=>$phoneEmail]]);
            }else{
                return response()->json(["error"=>['code'=>'006','message'=>'server is error!']]);
            };
        }else if(preg_match('/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/', $phoneEmail)){
            session()->put('email', $phoneEmail);
            session()->put('reg_state', '0');
            if($this->sendCodeEmail()){
                return response()->json(["success"=>['code'=>'102','message'=>'success send email code!', 'text'=>$phoneEmail]]);
            }else{
                return response()->json(["error"=>['code'=>'007','message'=>'server is error!']]);
            };
        }else if(preg_match('/@/', $phoneEmail)){
            return response()->json(["error"=>['code'=>'008','message'=>'Incorrect email format!']]);
        }else{
            return response()->json(["error"=>['code'=>'009','message'=>'Incorrect phone format!']]);
        }
        
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
        }else return 0;
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
        }else return 0;
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
        }else return 0;
    }

    /**
     * 注册请求2, 验证密码复杂度
     */
    public function register2(Request $request)
    {
        if(!$request->has('code')){
            return response()->json(["error"=>['code'=>'001','message'=>'code is null!']]);
        }
        if(!$request->has('password')){
            return response()->json(["error"=>['code'=>'002','message'=>'password is null!']]);
        }
        $code = $request->input('code');
        $p = $request->input('password');
        if(!((strlen($p)>7&&strlen($p)<21)&&((preg_match('/\d/', $p)&&preg_match('/[a-zA-Z]/', $p))||(preg_match('/[a-zA-Z]/', $p)&&preg_match('/\W/', $p))||(preg_match('/\d/', $p)&&preg_match('/\W/', $p))))){
            return response()->json(["error"=>['code'=>'003','message'=>'The password is too simple!']]);
        }
        if(session()->get('reg_state')){
            if(session()->has('sms_code')||session()->has('phone')){
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
            if(session()->get('email_code')==null||session()->get('email')==null){
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
    
    /**
     * 在数据库中创建用户
     * @param string $phone 电话号码
     * @param string $passwd 账号密码
     * @return integer|false
     */

    public function regCreatePhone($phone, $passwd)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $username = "";
        for ($i = 0; $i < 6; $i++ ){
            $username .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        $username .= $phone;

        $user = new User;
        $user->username = $username;
        $user->password = md5($passwd);
        $user->phone = $phone;
        if($user->save()){
            return $user->id;
        }else{
            return 0;
        };
        
    }

    /**
     * 在数据库中创建用户
     * @param string $email 邮箱
     * @param string $passwd 账号密码
     * @return integer|false
     */
    public function regCreateEmail($email, $passwd)
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
        $user->password = md5($passwd);
        $user->email = $email;
        if($user->save()){
            return $user->id;
        }else return 0;
        
    }

    /**
     * 登录请求
     */
    public function login(Request $request)
    {
        if(!$request->has('login_i')){
            return response()->json(["error"=>['code'=>'001','message'=>'login_i is empty!']]);
        }
        if(!$request->has('password')){
            return response()->json(["error"=>['code'=>'002','message'=>'password is empty!']]);
        }
        $login = $request->input('login_i');
        $passwd = $request->input('password');

        try{
        $web = User::where('phone', $login)
                ->orWhere('email', $login)
                ->orWhere('username', $login)
                ->first();
        if(empty($web)){
            return response()->json(["error"=>['code'=>'003','message'=>'User not found!']]);
        }
        $array = $web->toArray();
        }catch(Exception $e){
            return response()->json(["error"=>['code'=>'004','message'=>'Database exception!']]);
        }
        if($array['phone']==$login&&$array['password']==md5($passwd)||$array['email']==$login&&$array['password']==md5($passwd)||$array['username']==$login&&$array['password']==md5($passwd)){
            session()->put('logined', $array);
            if($request->input('login_state')==1){
                $code = $this->code();
                Cookie::queue('last_login_username', $login, 10080);
                Cookie::queue("login_token", $code, 10080);
                Cookie::queue("loginstate", 1, 10080);
                try{
                    $web = User::find($array['id']);
                    $web->login_token = $code;
                    $web->save();
                }catch(Exception $e){
                    return response()->json(["error"=>['code'=>'005','Database exception!']]);
                }
            }
            return response()->json(["success"=>['code'=>'101','message'=>'Success login!', 'avatar_url'=>$array['avatar_url']]]);
        }else{
            return response()->json(["error"=>['code'=>'006','message'=>'user or password is error!']]);
        }
    }

    /**
     * 检测用户session是否存在
     * 7天免登录, 重置免登录时间
     */
    public function cookieLogin(Request $request)
    {
        if(session()->has('logined')){
            return response()->json(['error'=>['code'=>'001', 'message'=>'session-logined is not exists!']]);
        }
        if($request->cookie('last_login_username')!=null&&$request->cookie('login_token')!=null){
            $login=$request->cookie('last_login_username');
            $login_token=$request->cookie('login_token');
            try{
                $web = User::where('phone', $login)
                        ->orWhere('email', $login)
                        ->orWhere('username', $login)
                        ->first();
            if(empty($web)){
                return response()->json(['error'=>['code'=>'002', 'message'=>'user not found!']]);
            }
            $array = $web->toArray();
            }catch(Exception $e){
                return response()->json(['error'=>['code'=>'003', 'message'=>'Database exception']]);
            }
            if($array['login_token']==$login_token){
                if($request->cookie('loginstate')){
                    if($request->cookie('loginstate')==1){
                        $code = $this->code();
                        Cookie::queue('last_login_username', $login, 10080);
                        Cookie::queue("login_token", $code, 10080);
                        Cookie::queue("loginstate", 1, 10080);
                        $user = User::find($array['id']);
                        $user->login_token = $code;
                        $user->save();
                    }
                }
                session()->put('logined', $array);
                return response()->json(['success'=>['code'=>'101', 'message'=>'You\'re logged in automatically', 'avatar_url' => $array['avatar_url']]]);
            }
        }
    }

    /**
     * qq登录请求
     * 
     */
    public function qqLogin()
    {
        return Socialite::driver('qq')->redirect();
    }

    /**
     * qq接口回调地址
     *
     * @return void
     */
    public function qqcallback()
    {
        try {
            $user = Socialite::driver('qq')->user();
            $web = User::firstWhere('qq_id', $user->id);
            if($web){
                session()->put('logined', $web->toArray());
                echo <<< STR
                    <script>
                    window.onunload = function(){
                        window.opener.location.reload()
                    }
                    window.onload = function(){
                        if(/Android|webOS|iPhone|iPod|BlackBerry|MicroMessenger/.test(navigator.userAgent)) {
                            window.location.href = 'http://wcz0.net/'
                        }else{
                            window.close()
                        }
                    }
                    </script>
                    STR;
            }else{
                // 注册过程
                $web2 = new User;
                $web2->username = Common::getRandCode(8);
                $web2->gender = ($user->user['gender']=='男')?1:2;
                $web2->nickname = $user->nickname;
                $web2->qq_id = $user->id;
                if($web2->save()){
                    session()->put('logined', User::find($web2->id)->toArray());
                    echo <<< STR
                    <script>
                    window.onunload = function(){
                        window.opener.location.reload()
                    }
                    window.onload = function(){
                        if(/Android|webOS|iPhone|iPod|BlackBerry|MicroMessenger/.test(navigator.userAgent)) {
                            window.location.href = 'http://wcz0.net/'
                        }else{
                            window.close()
                        }
                    }
                    </script>
                    STR;
                }else{
                    abort(500, '服务器异常');
                }
            }
        } catch (\Throwable $th) {
            echo '<script>window.close()</script>';
        }
        
    }

    /**
     * 生成一个随机码
     * 
     * @return string 随机码
     */
    public function code()
    {
        $data = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        $code ='';
        for($i=0;$i<64;$i++){
            $fontContext = substr($data, rand(0, strlen($data)-1), 1);
            $code .= $fontContext;
        }
        return $code;
    }

    public function test()
    {
        
    }
    /**
     * 检测登录状态
     *
     * @return void
     */
    public function checkLogined()
    {
        if(session()->get('logined')!=null){
            return response()->json(['error'=>['code'=>1, 'message'=>'Logged in']]);
        }else{
            return response()->json(['error'=>['code'=>0, 'message'=>'unlogged']]);
        }
    }
    /**
     * 退出登录
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        session()->flush();
        Cookie::queue(Cookie::forget('login_token'));
        return redirect('/');
    }

}