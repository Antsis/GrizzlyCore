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
     * 更新Session的存储信息
     *
     * @param [Array] $array
     * @return [Array] $data
     */
    public function updateSession($array)
    {
        $data = User::find($array['id'])->toArray();
        session()->put('logined', $data);
        return $data;
    }

    /**
     * 个人信息页面
     */
    public function profile(Request $request, $op='base')
    {
        $data = $this->updateSession(session()->get('logined'));
        if($data['birthday']==null){
            $data['birthday']=0;
        }
        $data['birthday']=date('Y-m-d', $data['birthday']);

        if($op=='base'){
            return view('profile.profile', [
                'title' =>  '个人资料',
                'data' => $data,
            ]);
        }else if($op=='contact'){
            return view('profile.profile_contact', [
                'title' =>  '个人资料',
                'data' => $data

            ]);
        }else{
            abort('参数错误');
        }
    }

    /**
     * 修改头像页面
     */
    public function avatar()
    {
        $data=$this->updateSession(session()->get('logined'));
        return view('profile.avatar', [
            'title' => '修改头像',
            'data' => $data
        ]);
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
     * 个人资料保存请求
     */
    public function profileSave(Request $request)
    {
        if(!$request->has('name')){
            $name = $request->input('name');
        }else $name = null;
        if(!$request->has('gender')){
            $gender = $request->input('gender');
        }else $gender = 0;
        if(!!$request->has('birthday')){
            $date = strtotime($request->input('birthday'));
        }else $date = 0;
        if(!!$request->has('signature')){
            $signature = $request->input('signature');
        }else{
            $signature = null;
        }
        $array = session()->get('logined');
        try{
            $user = User::find($array['id']);
            $user->name = $name;
            $user->gender = $gender;
            $user->birthday = $date;
            $user->signature = $signature;
            if($user->save()){
                $this->updateSession($array);
                return response()->json(['success'=>['code'=>'101', 'message' => 'update profile is success!']]);
            }else{
                return response()->json(['error'=>['code'=>'001', 'message' => 'update is error!']]);
            };
        }catch(Exception $e){
            return response()->json(['error'=>['code'=>'002', 'message' => 'update is error!']]);
        }
    }

    /**
     * 联系方式保存请求
     */
    public function profileContactSave(Request $request)
    {
        if($request->input('qq')==""){
            $qq=null;
        }else{
            $qq = $request->input('qq');
        }
        $array = session()->get('logined');
        $user = User::find($array['id']);
        try{
            $user->save(['qq' => $qq]);
            $this->updateSession($array);
            return response()->json(['success'=>['code'=>'101', 'message' => 'update profile is success!']]);
        }catch(Exception $e){
            return response()->json(['error'=>['code'=>'001', 'message' => 'update is error!']]);
        }
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
                $name = Common::getRandCode(20, false);

                // 裁剪头像并保存
                $image = Image::open($file);
                $image->thumb(200, 200, 2)->save('avatars/'. $name. '_200_200.jpg');
                $image->thumb(38, 38, 2)->save('avatars/'. $name. '_38_38.jpg');



                // 将头像url保存到数据库
                $user = User::find($data['id']);
                $user->avatar_url = 'avatars/'. $name;
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
