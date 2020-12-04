@extends('profile.layout')

@section('title')
账户安全
@endsection

@section('profile-content')
<div class="container py-3">
    <nav class="nav nav-pills nav-fill row">
        <a class="nav-item nav-link active col-md-4" href="{{url('profile/account/password')}}">修改密码</a>
        <a class="nav-item nav-link col-md-4" href="{{url('profile/account/email')}}">修改邮箱</a>
        <a class="nav-item nav-link col-md-4" href="{{url('profile/account/phone')}}">修改手机号</a>
    </nav>
</div>


<div class="container bg-light">
    <form class="px-3">
        <div class="form-group row">
          <label for="password-old-password" class="col-md-2 col-form-label">旧密码</label>
          <div class="col-md-4 ">
            <input type="password" class="form-control" id="password-old-password"  >
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="form-group row">
          <label for="password-new-password" class="col-md-2 col-form-label">新密码</label>
          <div class="col-md-4 col-xl-4">
            <input type="password" class="form-control" id="password-new-password" >
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="form-group row">
            <label for="password-confirm-password" class="col-md-2 col-form-label">确认密码</label>
            <div class="col-md-4">
                <input type="password" class="form-control" id="password-confirm-password">
                <div class="invalid-feedback"></div>
              </div>
        </div>
        <div class="form-group row py-4">
          <div class="col-md-2"></div>
            <div class="col text-md-left text-center ">
              <button id="password-save" type="submit" class="btn btn-primary col-md-2 col-sm-8" data-url="{{url('profile/account/password')}}">保存</button>
            </div>
          </div>
    </form>
</div>

@endsection