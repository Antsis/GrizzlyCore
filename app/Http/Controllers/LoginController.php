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
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * 登录请求
     */
    public function login(Request $request)
    {
        // 重写验证
        // if(!$request->has('login_i')){
        //     return response()->json(["error"=>['code'=>'001','message'=>'login_i is empty!']]);
        // }
        // if(!$request->has('password')){
        //     return response()->json(["error"=>['code'=>'002','message'=>'password is empty!']]);
        // }
        $login = $request->input('login_i');
        $passwd = $request->input('password');

        // try{
        //     $web = User::where('phone', $login)
        //             ->orWhere('email', $login)
        //             ->orWhere('username', $login)
        //             ->first();
        //     if(empty($web)){
        //         return response()->json(["error"=>['code'=>'003','message'=>'User not found!']]);
        //     }


        //     $array = $web->toArray();
        // }catch(Exception $e){
        //     return response()->json(["error"=>['code'=>'004','message'=>'Database exception!']]);
        // }
        // $data = DB::table('users')->selcet('');



        if($array['phone']==$login&&password_verify($passwd, $array['password'])||$array['email']==$login&&password_verify($passwd, $array['password'])||$array['username']==$login&&password_verify($passwd, $array['password'])){
            session()->put('logined', $array);
            if($request->input('login_state')==1){
                $code = $this->code();
                // Cookie::queue('last_login_username', $login, 10080);
                // Cookie::queue("login_token", $code, 10080);
                // Cookie::queue("loginstate", 1, 10080);
                try{
                    $web = User::find($array['id']);
                    $web->login_token = $code;
                    $web->save();
                }catch(Exception $e){
                    return response()->json(["error"=>['code'=>'005','Database exception!']]);
                }
            }

            return $this->success();
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
        $code = '';
        for($i=0;$i<64;$i++){
            $fontContext = substr($data, rand(0, strlen($data)-1), 1);
            $code .= $fontContext;
        }
        return $code;
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
