<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Common;
use App\Models\Access;
use App\Models\AccessLog;
use App\Models\RoleAccess;
use App\Models\User;
use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;
use League\OAuth1\Client\Server\Tumblr;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        /**
         * 检查用户的权限
         * 通过用户检索出所属角色
         * 通过角色检索出所有权限
         * 再进行判断
         */
        if(session()->has('logined')){
            $uid = session()->get('logined')['id'];
            // 判断管理员
            if(User::find($uid)->is_admin){
                $flag = true;
                goto f;
            }
            $role_ids = Common::getArray(UserRole::where('uid', $uid)->get(), 'role_id');
            if(!$role_ids){
                return abort(403, '你没有权限!');
            }
            foreach ($role_ids as $item) {
                $access = Common::getArray(RoleAccess::where('role_id', $item)->get(), 'access_id');
            }
            if(!$access){
                return abort(403, '你没有权限!');
            }
            foreach($access as $item){
                $urls[] = Access::where('id', $item)->value('urls');
            }
            $array = [];
            foreach ($urls as $url) {
                $tmp = json_decode($url);
                if(is_null($tmp)){
                    continue;
                }else{
                    $array = array_merge($array, $tmp);
                }
            }

            // if(in_array('/'.$request->path(), $array)){
            //     return $next($request);
            // }else{
            //     return redirect('/');
            // }
            // 使用正则表达式, 添加权限更为方便
            $curl = '/'.$request->path();
            foreach($array as $item){
                $str =  str_replace(['/','*'], ['\/', '.*'], $item);
                if(preg_match('/'.$str.'/', $curl)){
                    $flag = true;
                }else{
                    $flag = false;
                }
            }
            
            f:
            if($flag){
                // 日志记录
                $log = new AccessLog();
                $log->uid = $uid;
                $log->target_url = $request->fullUrl();
                $log->http_type = $request->method();
                $log->ip = $request->ip();
                $log->ua = $request->server('HTTP_USER_AGENT');
                $log->created_at = time();
                $log->save();
                return $next($request);
            }else{
                return abort(403, '你没有权限!');
            }
        }else{
            return abort(403, '你没有权限!');
        }
    }
    
}
