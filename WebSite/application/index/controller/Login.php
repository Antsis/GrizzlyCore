<?php
namespace app\index\controller;

use app\index\controller\SendSms;
use app\index\controller\Captcha;
use think\Session;
use app\index\model\Web;
use Exception;
use think\Controller;
use think\Cookie;

class Login extends Controller
{
    public function __construct()
    {
        parent::__construct();
        new Web();
    }
    public function verify()
    {     
        $captcha = new Captcha();
        $captcha->captcha();
    }

    public function checkCode()
    {
        if(empty($_POST['code'])){
            return false;
        }
        $code = strtolower($_POST['code']);
        if(Session::get('verify_code')==null){
            return false;
        }
        if($code==Session::get('verify_code')){
            return true;
        }else{
            return false;
        }
    }

    public function register()
    {   
        if(empty($_POST['code'])){
            return "error";
        }
        if(empty($_POST['phone_email'])){
            return "error";
        }

        $code = strtolower($_POST['code']);
        $phoneEmail = $_POST['phone_email'];

        if(Session::get('verify_code')==null){
            return "error1";
        }
        if($code!=Session::get('verify_code')){
            return "error1";
        }
        if($this->cehckUserIs($phoneEmail)){
            return 'error3';
        }
        if(preg_match('/^1[3-9]\d{9}$/', $phoneEmail)){
            Session::set('phone', $phoneEmail);
            Session::set('reg_state', '1');
            if($this->sendCodeSms()){
                return $phoneEmail;
            }else return 'error2';
        }else if(preg_match('/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/', $phoneEmail)){
            Session::set('email', $phoneEmail);
            Session::set('reg_state', '0');
            if($this->sendCodeEmail()){
                return $phoneEmail;
            }else return 'error2';
        }else return "error2";
    }
    /**
     * 检查用户是否存在
     * @param string 用户登录名
     * @return true|false
     */
    public function cehckUserIs($login)
    {
        $res = Web::where('phone', $login)
                ->whereor('email', $login)
                ->whereor('username', $login)
                ->find();
        if($res){
            return 1;
        }else return 0;
    }


    public function sendCodeSmsEmail()
    {
        if(Session::get('reg_state')){
            $this->sendCodeSms();
        }else $this->sendCodeSmsEmail();
    }

    /**
     * 这里调用了PHPMailer发送邮件
     * @return true|false 返回是否成功
     */
    public function sendCodeEmail()
    {
        //此类涉及个人账户
        $sm = new SendEmail();
        $res = $sm->sendCodeEmail(Session::get('email'));
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
        $res = $sm->sendCodeSms(Session::get('phone'));
        if($res==0){
            return 1;
        }else return 0;
    }

    public function register2()
    {
        if(empty($_POST['code'])){
            return "error";
        }
        if(empty($_POST['password'])){
            return "error";
        }
        $code = $_POST['code'];
        $p = $_POST['password'];
        if(!((strlen($p)>7&&strlen($p)<21)&&((preg_match('/\d/', $p)&&preg_match('/[a-zA-Z]/', $p))||(preg_match('/[a-zA-Z]/', $p)&&preg_match('/\W/', $p))||(preg_match('/\d/', $p)&&preg_match('/\W/', $p))))){
            return "error2";
        }
        if(Session::get('reg_state')){
            if(Session::get('sms_code')==null||Session::get('phone')==null){
                return "error";
            }
            if($code!=Session::get('sms_code')){
                return "error1";
            }
            $phone = Session::get('phone');
            $state = $this->regCreatePhone($phone, $p);
            if($state!=0){
                    $res = Web::get($state);
                    $array = $res->toArray();
                    Session::set('logined', $array);
                    return "success";
            }else return "error";
        }else{
            if(Session::get('email_code')==null||Session::get('email')==null){
                return 'error';
            }
            if($code!=Session::get('email_code')){
                return "error1";
            }
            $email = Session::get('email');
            $state = $this->regCreateEmail($email, $p);
            if($state!=0){
                $res = Web::get($state);
                $array = $res->toArray();
                Session::set('logined', $array);
                return "success";
            }else return "error";
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

        $user = new Web;
        $user->username = $username;
        $user->password = md5($passwd);
        $user->phone = $phone;
        try{
            if($user->save()){
                return $user->id;
            }else return 0;
        }catch(Exception $e){
            return 0;
        }
        
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

        $user = new Web;
        $user->username = $username;
        $user->password = md5($passwd);
        $user->email = $email;
        try{
            if($user->save()){
                return $user->id;
            }else return 0;
        }catch(Exception $e){
            return 0;
        }
        
    }

    public function login()
    {
        if(empty($_POST['login_i'])||empty($_POST['password'])){
            return "error";
        }
        if($_POST['login_i']=='null'){
            return 'error1';
        }
        $login = $_POST['login_i'];
        $passwd = $_POST['password'];

        try{
        $res = Web::where('phone', $login)
                ->whereor('email', $login)
                ->whereor('username', $login)
                ->find();
        if(empty($res)){
            return "error1";
        }
        $array = $res->toArray();
        }catch(Exception $e){
            return "error";
        }
        if($array['phone']==$login&&$array['password']==md5($passwd)||$array['email']==$login&&$array['password']==md5($passwd)||$array['username']==$login&&$array['password']==md5($passwd)){
            Session::set('logined', $array);
            if($_POST['login_state']==1){
                $code = $this->code();
                Cookie::set('last_login_username', $login, ['expire'=>604800]);
                Cookie::set("login_token", $code, ['expire'=>604800]);
                Cookie::set("loginstate", 1, ['expire'=>604800]);
                try{
                    $user = Web::get($array['id']);
                    $user->login_token = $code;
                    $user->save();
                }catch(Exception $e){
                    return 'error3';
                }
            }
            return "success";
        }else return "error2";
    }
    public function cookieLogin()
    {
        if(Session::has('logined')){
            return 'logined';
        }
        if(Cookie::has('last_login_username')&&Cookie::has('login_token')){
            $login=Cookie::get('last_login_username');
            $login_token=Cookie::get('login_token');
            try{
                $res = Web::where('phone', $login)
                        ->whereor('email', $login)
                        ->whereor('username', $login)
                        ->find();
            if(empty($res)){
                return "error1";
            }
            $array = $res->toArray();
            }catch(Exception $e){
                return "error";
            }
            if($array['login_token']==$login_token){
                if(Cookie::has('loginstate')){
                    if(Cookie::get('loginstate')==1){
                        $code = $this->code();
                        Cookie::set('last_login_username', $login, ['expire'=>604800]);
                        Cookie::set("login_token", $code, ['expire'=>604800]);
                        Cookie::set("loginstate", 1, ['expire'=>604800]);
                        try{
                            $user = Web::get($array['id']);
                            $user->login_token = $code;
                            $user->save();
                        }catch(Exception $e){
                            return 'error';
                        }
                    }
                }
                Session::set('logined', $array);
                return 'success';
            }
        }return 'error';
    }

    /**
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

}