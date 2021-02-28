<?php

namespace App\Http\Controllers;

use App\Mail\AccountSecurity;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    

    /**
     * a User Model
     *
     * @var Model
     */
    protected $user;

    /**
     * 更新Session的存储信息
     */
    public function updateSession()
    {
        $this->user = User::find(session()->get('logined')['id']);
        session()->put('logined', $this->user->toArray());
        

    }


    // public function __construct(Request $request)
    // {
    //     $this->user = User::find(session()->get('logined')['id']);
    //     session()->put('logined', $this->user->toArray());
    // }


    /**
     * 个人信息页面
     */
    public function index(Request $request)
    {
        $this->updateSession();

        switch ($request->method()) {
            case 'GET':
                if($this->user->birthday==null){
                    $this->user->birthday=0;
                }
                $this->user->birthday = $date = date('Y-m-d', $this->user->birthday);
                
                return view('profile.index', [
                    'title' =>  '个人资料',
                    'user' => $this->user,
                    'genders' => ['保密', '男', '女'],
                    ]);
                break;
            case 'PUT':
                if($request->has('name')){
                    $name = $request->input('name');
                }else $name = null;
                
                if($request->has('gender')){
                    $gender = $request->input('gender');
                }else $gender = 0;

                if($request->has('birthday')){
                    $date = strtotime($request->input('birthday'));
                }else $date = 0;
                if($request->has('signature')){
                    $signature = $request->input('signature');
                }else $signature = null;
                $this->user->name = $name;
                $this->user->gender = $gender;
                $this->user->birthday = $date;
                $this->user->signature = $signature;
                if($this->user->save()){
                    return response()->json(['success'=>['code'=>'101', 'message' => 'update profile is success!']]);
                }
                return response()->json(['error'=>['code'=>'001', 'message' => 'update is error!']]);
                break;
            default:
                response()->json(['error' => ['code' => '001', 'message' => 'ation is know']]);
                break;
        }
        

    }

    /**
     * 联系方式页面
     *
     * @param Request $request
     * @return void
     */
    public function contact(Request $request)
    {
        $this->updateSession();
        switch ($request->method()) {
            case 'GET':
                return view('profile.contact', [
                    'title' =>  '个人资料',
                    'user' => $this->user,
                ]);
                break;
            case 'PUT':
                if($request->has('qq')){
                    $qq = $request->input('qq');
                }else $qq=null;
                $this->user->qq = $qq;
                if($this->user->save()){
                    return response()->json(['success'=>['code'=>'101', 'message' => 'update profile is success!']]);
                }
                return response()->json(['error'=>['code'=>'003', 'message' => 'Database is excption !']]);
                break;
            default:
                response()->json(['error' => ['code' => '001', 'message' => 'ation is know']]);
                break;
        }
    }

    /**
     * 修改头像页面
     */
    public function avatar(Request $request)
    {
        $this->updateSession();
        switch ($request->method()) {
            case 'GET':
                return view('profile.avatar', [
                    'title' => '修改头像',
                    'user' => $this->user
                ]);                
                break;
            case 'POST':
                if(!$request->hasFile('image')){
                    return response()->json(['error' => ['code' => '001', 'message' => 'upload file is null']]);
                }
                $file = $request->file('image');
                if($file->isValid()){
                    $ext = $file->extension();
                    if($ext == "jpeg" || $ext == "png" || $ext == 'jpg'){
                        $md5 = md5($this->user['username']);
                        //  TODO : 保存图片的分辨减小, 而且导航栏使用静态图片
                        $file->storeAs('avatar', "$md5.jpg");
                        // 将头像url保存到数据库
                        $this->user->avatar_url = env('APP_URL').'/avatar/'. $md5;
                        if($this->user->save()){
                            return response()->json(['success'=>['code'=>'101', 'message' => 'file upload is success']]);
                        }else{
                            return response()->json(['error'=>['code'=>'002', 'message'=>'The file is not in picture format.', 'ext'=>$ext]]);
                        };
                    }else{
                        return response()->json(['error'=>['code'=>'003', 'message'=>'The file is not in picture format.', 'ext'=>$ext]]);
                    }
                }else{
                    return response()->json(['error'=>['code'=>'004', 'message'=>'File is empty']]);
                }
                break;
            default:
                return response()->json(['error' => ['code' => '001', 'message' => 'action is null']]);
                break;
        }

        
    }

    /**
     * 账号安全页面
     */
    public function password(Request $request)
    {
        $this->updateSession();
        switch ($request->method()) {
            case 'GET':
                return view('profile.account.password', [
                    'title' => '修改密码',
                    'user' => $this->user,
                ]);
                break;
            case 'PUT':
                if(!$request->has('old_p')){
                    return response()->json(['error' => ['code' => '002', 'meassage' => 'old password is null']]);
                }
                if(!$request->has('new_p')){
                    return response()->json(['error' => ['code' => '003', 'meassage' => 'new password is null']]);
                }
                if(!$request->has('confirm_p')){
                    return response()->json(['error' => ['code' => '004', 'meassage' => 'new password is null']]);
                }
                $c_password = $request->get('new_p');
                if($c_password!=$request->get('confirm_p')){
                    return response()->json(['error' => ['code' => '005', 'meassage' => 'new password and confirm is error']]);
                }
                if(!password_verify($request->get('old_p'), $this->user->password)){
                    return response()->json(['error' => ['code' => '006', 'meassage' => 'old password is error']]);
                }
                $this->user->password = bcrypt($c_password);
                if($this->user->save()){
                    return response()->json(['success' => ['code' => '101', 'message' => 'password is successfully changed']]);
                }
                return response()->json(['error' => ['code' => '007', 'meassage' => 'old password is error']]);
            default:
                return response()->json(['error' => ['code' => '001', 'meassage' => 'HTTP action is error']]);
                break;
        }

    }

    /**
     * 修改邮箱
     *
     * @return void
     */
    public function email(Request $request)
    {
        $this->updateSession();

        switch ($request->method()) {
            case 'GET':
                return view('profile.account.email', [
                    'title' => '修改邮箱',
                    'user' => $this->user,
                ]);
                break;
                // 发送邮件
            case 'POST':
                if(!$request->has('password')){
                    return response()->json(['error' => ['code' => '002', 'meassage' => 'old password is null']]);
                }
                if(!$request->has('email')){
                    return response()->json(['error' => ['code' => '003', 'meassage' => 'new email is null']]);
                }
                if(!password_verify($request->get('password'), $this->user->password)){
                    return response()->json(['error' => ['code' => '004', 'meassage' => 'old password is error']]);
                }
                $emailCode = "";
                for($i=0;$i<6;$i++){
                    $emailCode .= rand(0, 9);
                }
                session()->put('new_email_code', $emailCode);
                Mail::to($request->get('email'))->send(new AccountSecurity($emailCode));
                return response()->json(['success' => ['code' => '101', 'meassage' => 'email code is successfully send']]);
                break;
            case 'PUT':
                if(!$request->has('password')){
                    return response()->json(['error' => ['code' => '002', 'meassage' => 'old password is null']]);
                }
                if(!$request->has('email')){
                    return response()->json(['error' => ['code' => '003', 'meassage' => 'new email is null']]);
                }
                if(!$request->has('code')){
                    return response()->json(['error' => ['code' => '004', 'meassage' => 'code is null']]);
                }
                if(!session()->has('new_email_code')){
                    return response()->json(['error' => ['code' => '005', 'meassage' => 'new email code is null']]);
                }
                if(!password_verify($request->get('password'), $this->user->password)){
                    return response()->json(['error' => ['code' => '006', 'meassage' => 'old password is error']]);
                }
                if($request->get('code')!=session()->get('new_email_code')){
                    return response()->json(['error' => ['code' => '007', 'meassage' => 'code is error']]);
                }
                $this->user->email = $request->get('email');
                if($this->user->save()){
                    return response()->json(['success' => ['code' => '101', 'meassage' => 'email is successfully changed']]);
                }
                return response()->json(['error' => ['code' => '008', 'meassage' => 'database is error']]);
                break;
            default:
                return response()->json(['error' => ['code' => '001', 'meassage' => 'HTTP action is error']]);
                break;
        }

        
    }

    public function phone(Request $request)
    {
        $this->updateSession();

        switch ($request->getMethod()) {
            case 'GET':
                return view('profile.account.phone', [
                    'title' => '修改手机',
                    'user' => $this->user,
                ]);
                break;
            
            default:
                # code...
                break;
        }
    }
    
}
