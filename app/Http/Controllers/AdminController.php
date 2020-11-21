<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Event\ViewEvent;

use function Ramsey\Uuid\v1;

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
                    foreach($user_roles as $_list){
                        $arr[] = $_list->role_id;
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
                foreach($server_roles as $_list){
                    if(!in_array($_list->role_id, $client_roles)){
                        $_list->delete();
                    }
                }
                // C in S 添加操作
                foreach($client_roles as $_list){
                    if($_list==null){
                        continue;
                    }else{
                        if(!in_array($_list, $server_roles->modelKeys())){
                            $user_role = new UserRole;
                            $user_role->uid = $uid;
                            $user_role->role_id =  $_list;
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
            case 'GET':
                $roles = Role::paginate(5);
                return view('admin.role', ['roles' => $roles]);
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
                if(!$request->has('access-id')){
                    return response()->json(['error' => ['code' => '001', 'message' => 'role-id is null']]);
                }
                $role = Role::find((int)$request->input('role-id'));
                if($role->delete()){
                    return response()->json(['success' => ['code' => '101', 'message' => 'role success delete!']]);
                }else{
                    return response()->jsoin(['error' => ['code' => '001', 'message' => 'Database is error']]);
                }
                break;
            case 'GET':
                $access = Access::paginate(5);
                return view('admin.access', ['access' => $access]);
                break;
            default:
                return response()->json(['error'=>['code' => '001', 'message' => '']]);
        }
    }


    
    
}
