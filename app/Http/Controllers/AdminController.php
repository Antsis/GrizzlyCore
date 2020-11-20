<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                return view('admin.user', ['users' => $users]);
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
                break;
            default:
                return response()->json(['error'=>['code' => '001', 'message' => '']]);
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
