<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Image;
use Exception;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * an Array 
     *
     * @var [Array]
     */
    protected $user_info;

    /**
     * a User Model
     *
     * @var Model
     */
    protected $user;

    /**
     * 更新Session的存储信息
     *
     */
    public function updateSession()
    {
        $this->user = User::find(session()->get('logined')['id']);
        session()->put('logined', $this->user->toArray());
    }

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
                $this->user->birthday=date('Y-m-d', $this->user->birthday);
                
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
                $data=$this->updateSession(session()->get('logined'));
                return view('profile.avatar', [
                    'title' => '修改头像',
                    'data' => $data
                ]);                
                break;
            case 'PUT':

                break;
            default:
                return response()->json(['error' => ['code' => '001', 'message' => 'action is null']]);
                break;
        }

        
    }

    /**
     * 账号安全页面
     */
    public function account()
    {
        $data=$this->updateSession(session()->get('logined'));
        
        return view('profile.account', [
            'title' => '账号安全',
            'data' => $data
        ]);
    }
    

    
    /**
     * 头像上传请求
     */
    public function avatarUpload(Request $request)
    {
        $file = $request->file('image');
        $data = session()->get('logined');
        if(empty($file)){
            return response()->json(['error' => ['code' => '001', 'message' => 'upload file is null']]);
        }
        if($file->isValid()){
            $ext = $file->extension();
            if($ext == "jpeg" || $ext == "png"){
                // 生成随机名
                // $name = Common::getRandCode(20, false);
                $md5 = md5($data['username']);
                // 裁剪头像并保存
                // $image = Image::open($file);
                // $image->save('avatar/'. $md5. '.jpg');
                // $image->thumb(38, 38, 2)->save('avatar/'. $name. '_38_38.jpg');

                // 将头像url保存到数据库
                $user = User::find($data['id']);
                $user->avatar_url = env('APP_URL').'/avatar/'. $md5;
                if($user->save()){
                    $this->updateSession($data);
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
        
    }
    
}
