<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Tests\Unit\MainTest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function(){
    return view('index.index');
});
Route::get('bbs', function(){
    return view('index.bbs');
});
Route::get('about', function(){
    return view('index.about');
});
Route::get('contact', function(){
    return view('index.contact');
});

Route::any('test', [MainTest::class, 'testMain']);
// Route::any('test', [TestController::class, 'Main']);



Route::prefix('user')->group(function(){
    //验证码
    Route::get('verify', [UserController::class, 'create']);

    // 动态监测验证码
    Route::get('checkCode', [UserController::class, 'checkCode']);
    Route::post('register', [UserController::class, 'store']);

    Route::post('sendCodeSmsEmail', [UserController::class, 'sendCodeSmsEmail']);

});

Route::prefix('login')->group(function(){
    //验证码
    // Route::get('verify', [UserController::class, 'create']);

    Route::post('cookieLogin', [LoginController::class, 'cookieLogin']);
    // 动态监测验证码
    // Route::get('checkCode', [UserController::class, 'checkCode']);
    
    // Route::post('register', [UserController::class, 'register']);

    // Route::post('register2', [LoginController::class, 'register2']);
    // Route::post('sendCodeSmsEmail', [UserController::class, 'sendCodeSmsEmail']);
    

    Route::get('qqLogin', [LoginController::class, 'qqLogin']);
    Route::post('login', [LoginController::class, 'login']);
    Route::get('logout', [LoginController::class, 'logout']);
    Route::any('checkLogined', [LoginController::class, 'checkLogined']);
    Route::get('qqcallback', [LoginController::class, 'qqcallback']);
    Route::get('logout', [LoginController::class, 'logout']);
});

Route::middleware('checksession')->prefix('profile')->group(function(){
    Route::get('profile/{op?}', [ProfileController::class, 'profile']);
    Route::get('avatar', [ProfileController::class, 'avatar']);
    Route::get('account', [ProfileController::class, 'account']);
    Route::post('avatarUpload', [ProfileController::class, 'avatarUpload']);
    Route::post('profileSave', [ProfileController::class, 'profileSave']);
    Route::post('profileContactSave', [ProfileController::class, 'profileContactSave']);
});

Route::middleware(['checksession', 'checkaccess'])->prefix('admin')->group(function(){
    Route::get('index', function(){
        return view('admin.index');
    });
    Route::any('user', [AdminController::class, 'user']);
    Route::any('role', [AdminController::class, 'role']);
    Route::any('access', [AdminController::class, 'access']);
});