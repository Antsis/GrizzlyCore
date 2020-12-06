@extends('profile.layout')

@section('title')
账户安全
@endsection

@section('profile-content')
<div class="container py-3">
    <nav class="nav nav-pills nav-fill row">
        <a class="nav-item nav-link col-md-4" href="{{url('profile/account/password')}}">修改密码</a>
        <a class="nav-item nav-link active col-md-4" href="{{url('profile/account/email')}}">修改邮箱</a>
        <a class="nav-item nav-link col-md-4" href="{{url('profile/account/phone')}}">修改手机号</a>
    </nav>
</div>

<div class="container bg-light">
    <form class="px-3">
        <div class="form-group row">
          <label for="email-old-password" class="col-md-2 col-form-label">旧密码</label>
          <div class="col-md-4 ">
            <input type="password" class="form-control" id="email-old-password"  >
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="new-email" class="col-md-2 col-form-label">新邮箱</label>
          <div class="col-md-4 col-xl-4">
            <input type="text" class="form-control" id="email-new-email" >
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2"></div>
            <div class="col text-md-left text-center">
                <button id="email_send_email_code_btn" class="btn btn-primary col-md-auto col-sm-8" data-url="{{url('profile/account/email')}}">发送验证码</button>
            </div>
            
        </div>
        <div class="form-group row">
            <label for="email_confirm-code" class="col-md-2  col-form-label">验证码</label>
            <div class="col-md-4">
                <input type="text" class="form-control" id="email-confirm-code">
                <div class="invalid-feedback"></div>
              </div>
        </div>
        <div class="form-group row py-4">
          <div class="col-md-2"></div>

            <div class="col text-md-left text-center ">
              <button id="email-save" type="submit" class="btn btn-primary col-md-2 col-sm-8" data-url="{{url('profile/account/email')}}">保存</button>
            </div>
          </div>
    </form>
</div>

@endsection