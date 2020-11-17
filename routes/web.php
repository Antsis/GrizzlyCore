<?php

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


Route::get('/', [IndexController::class, 'index']);
Route::get('about', [IndexController::class, 'about']);
Route::get('bbs', [IndexController::class, 'bbs']);
Route::get('contact', [IndexController::class, 'contact']);

Route::get('logout', [IndexController::class, 'logout']);
Route::any('checkLogined', [IndexController::class, 'checkLogined']);
Route::any('updateData', [IndexController::class, 'updateData']);
Route::get('qqcallback', [LoginController::class, 'qqcallback']);


Route::prefix('login')->group(function(){
    Route::post('cookieLogin', [LoginController::class, 'cookieLogin']);
    Route::post('checkCode', [LoginController::class, 'checkCode']);
    Route::post('register', [LoginController::class, 'register']);
    Route::post('register2', [LoginController::class, 'register2']);
    Route::post('sendCodeSmsEmail', [LoginController::class, 'sendCodeSmsEmail']);
    Route::post('login', [LoginController::class, 'login']);
    Route::get('qqLogin', [LoginController::class, 'qqLogin']);
    Route::get('verify', [LoginController::class, 'verify']);

});

Route::middleware('checksession')->prefix('profile')->group(function(){
    Route::get('profile/{op?}', [ProfileController::class, 'profile']);
    Route::get('avatar', [ProfileController::class, 'avatar']);
    Route::get('account', [ProfileController::class, 'account']);
    Route::post('avatarUpload', [ProfileController::class, 'avatarUpload']);
    Route::get('avatar', [ProfileController::class, 'avatar']);
    Route::get('avatar', [ProfileController::class, 'avatar']);
    Route::get('avatar', [ProfileController::class, 'avatar']);
});