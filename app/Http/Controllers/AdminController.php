<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Role;
use App\Models\RoleAccess;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

/**
 * 后台相关控制器
 */
class AdminController extends Controller
{
    /**
     * 用户管理页面
     */
    public function user(Request $request)
    {
        switch($request->method()){
            case 'GET':
                $users = User::paginate(5);
                $roles = Role::all();
                if($request->has('id')){
                    $user_roles = UserRole::where('uid', $request->input('id'))->get();
                    $arr = [];
                    foreach($user_roles as $item){
                        $arr[] = $item->role_id;
                    }
                    return response()->json($arr);
                }
                return view('admin.user', [
                    'users' => $users, 
                    'roles' => $roles,
                ]);
                break;
            case 'DELETE':
                if(!$request->has('user-id')){
                    return response()->json(['error'=>['code' => '001', 'message' => 'user-id is null']]);
                }
                $user = User::find((int)$request->input('user-id'));
                if($user->delete()){
                    return response()->json(['success'=>['code' => '101', 'message' => 'user success delete']]);
                }else{
                    return response()->json(['error'=>['code' => '002', 'message' => 'Databse is error']]);
                }
                break;
            case 'PUT':
                if(!$request->has('user-id')&&!$request->has('user-name')){
                    return response()->json(['error'=>['code' => '001', 'message' => 'user-id or username is null']]);
                }
                $user = User::find((int)$request->input('user-id'));
                $user->username = $request->input('user-name');
                if($request->has('user-email')){
                    $user->email = $request->input('user-email');
                }
                if($user->save()){
                    return response()->json(['success'=>['code' => '101', 'message' => 'user profile is updated']]);
                }else{
                    return response()->json(['error'=>['code' => '002', 'message' => 'Database is error']]);
                }
                break;
            case 'POST':
                if(!$request->has('user-id')){
                    return response()->json(['error'=>['code' => '001', 'message' => 'user-id is null']]);
                }
                $uid = $request->input('user-id');
                // 找出用户所有的角色, 
                $server_roles = UserRole::where('uid', $uid)->get();
                // $user_roles = $user_roles->modelKeys();
                //判断角色数组中的id是否和传递过来数组中的id的是否存在
                //如果存在则不变, 传递过来的id如果角色未拥有则添加
                //角色id如果拥有传递过来的id不相同则删除
                $client_roles = $request->input('user-roles');
                //特殊判断
                // if($client_roles[0]==""&&count($client_roles)==1){
                //     return response()->json(['notify'=>['code' => '1', 'message' => 'Nothing is updated']]);
                // }
                // S in C 删除操作
                foreach($server_roles as $item){
                    if(!in_array($item->role_id, $client_roles)){
                        $item->delete();
                    }
                }
                // C in S 添加操作
                foreach($client_roles as $item){
                    if($item==null){
                        continue;
                    }else{
                        if(!in_array($item, Common::getArray($server_roles, 'role_id'))){
                            $user_role = new UserRole;
                            $user_role->uid = $uid;
                            $user_role->role_id =  $item;
                            if(!$user_role->save()){
                                return response()->json(['error'=>['code' => '002', 'message' => 'Database is error']]);
                            }
                        }
                    }
                }
                return response()->json(['success'=>['code' => '101', 'message' => 'user roles is updated']]);
                break;
            default:
                return response()->json(['error'=>['code' => '001', 'message' => 'HTTP Action is error']]);
        }
    }

    /**
     * 角色管理页面
     * 
     * Role 资源相关
     * 
     *
     */
    public function role(Request $request)
    {
        switch($request->method()){
            case 'POST':
                if(!$request->has('role-name')){
                    return response()->json(['error' => ['code' => '001', 'message' => 'form role is null']]);
                }
                $role = new Role;
                $role->name = $request->input('role-name');
                if($role->save()){
                    return response()->json(['success' => ['code' => '101', 'message' => 'insert success!']]);
                }else{
                    return response()->jsoin(['error' => ['code' => '002', 'message' => 'Database is error']]);
                }
                break;
            case 'PUT':
                if(!$request->has('role-name')&&!$request->has('role-id')){
                    return response()->json(['error' => ['code' => '001', 'message' => 'form role is null']]);
                }
                $role = Role::find((int)$request->input('role-id'));
                $role->name = $request->input('role-name');
                if($role->save()){
                    return response()->json(['success' => ['code' => '101', 'message' => 'insert success!']]);
                }else{
                    return response()->jsoin(['error' => ['code' => '002', 'message' => 'Database is error']]);
                }
                break;
            case 'DELETE':
                if(!$request->has('role-id')){
                    return response()->json(['error' => ['code' => '001', 'message' => 'role-id is null']]);
                }
                $role = Role::find((int)$request->input('role-id'));
                if($role->delete()){
                    return response()->json(['success' => ['code' => '101', 'message' => 'role success delete!']]);
                }else{
                    return response()->jsoin(['error' => ['code' => '001', 'message' => 'Database is error']]);
                }
                break;
            case 'PATCH':
                if(!$request->has('role-id')){
                    return response()->json(['error'=>['code' => '001', 'message' => 'role-id is null']]);
                }
                $role_id = $request->input('role-id');
                // 找出角色所有的权限, 
                $server_access = RoleAccess::where('role_id', $role_id)->get();
                // $user_roles = $user_roles->modelKeys();
                //判断角色数组中的id是否和传递过来数组中的id的是否存在
                //如果存在则不变, 传递过来的id如果角色未拥有则添加
                //角色id如果拥有传递过来的id不相同则删除
                //与用户选择角色同理
                $client_access = $request->input('role-access');
                //特殊判断
                // if($client_roles[0]==""&&count($client_roles)==1){
                //     return response()->json(['notify'=>['code' => '1', 'message' => 'Nothing is updated']]);
                // }
                // S in C 删除操作
                foreach($server_access as $itme){
                    if(!in_array($itme->access_id, $client_access)){
                        $itme->delete();
                    }
                }
                // C in S 添加操作
                foreach($client_access as $item){
                    if($item==null){
                        continue;
                    }else{
                        if(!in_array($item, Common::getArray($server_access, 'access_id'))){
                            $role_access = new RoleAccess;
                            $role_access->role_id = $role_id;
                            $role_access->access_id =  $item;
                            if(!$role_access->save()){
                                return response()->json(['error'=>['code' => '002', 'message' => 'Database is error']]);
                            }
                        }
                    }
                }
                return response()->json(['success'=>['code' => '101', 'message' => 'role access is updated']]);
                break;
            case 'GET':
                $roles = Role::paginate(5);
                $access_list = Access::all();
                if($request->has('id')){
                    $role_access = RoleAccess::where('role_id', $request->input('id'))->get();
                    $arr = [];
                    foreach($role_access as $item){
                        $arr[] = $item->access_id;
                    }
                    return response()->json($arr);
                }
                return view('admin.role', [
                    'roles' => $roles,
                    'access_list' => $access_list,
                ]);
                break;
            default:
                return response()->json(['error'=>['code' => '001', 'message' => '']]);
        }
    }

    /**
     * 权限管理页面
     * 
     */
    public function access(Request $request)
    {
        switch($request->method()){
            case 'POST':
                if(!$request->has('access-name')){
                    return response()->json(['error' => ['code' => '001', 'message' => 'access name is null']]);
                }
                $urls = explode("\n", $request->input('urls'));
                if(!$urls){
                    return response()->json(['error' => ['code' => '002', 'message' => 'Urls are not compliant']]);
                }
                $access = new Access();
                $access->name = $request->input('access-name');
                $access->urls = json_encode($urls);
                if($access->save()){
                    return response()->json(['success' => ['code' => '101', 'message' => 'insert success!']]);
                }else{
                    return response()->jsoin(['error' => ['code' => '003', 'message' => 'Database is error']]);
                }
                break;
            case 'PUT':
                if(!$request->has('access-name')&&!$request->has('access-id')){
                    return response()->json(['error' => ['code' => '001', 'message' => 'access name or id is null']]);
                }
                $urls = explode("\n", $request->input('urls'));
                $access = Access::find((int)$request->input('access-id'));
                $access->name = $request->input('access-name');
                $access->urls = json_encode($urls);
                if($access->save()){
                    return response()->json(['success' => ['code' => '101', 'message' => 'insert success!']]);
                }else{
                    return response()->jsoin(['error' => ['code' => '002', 'message' => 'Database is error']]);
                }
                break;
            case 'DELETE':
                if(!$request->has('access-id')){
                    return response()->json(['error' => ['code' => '001', 'message' => 'access-id is null']]);
                }
                $access = Access::find((int)$request->input('access-id'));
                if($access->delete()){
                    return response()->json(['success' => ['code' => '101', 'message' => 'access success delete!']]);
                }else{
                    return response()->jsoin(['error' => ['code' => '001', 'message' => 'Database is error']]);
                }
                break;
            case 'GET':
                $access_list = Access::paginate(5);
                return view('admin.access', [
                    'access_list' => $access_list,
                ]);
                break;
            default:
                return response()->json(['error'=>['code' => '001', 'message' => '']]);
        }
    }
}
