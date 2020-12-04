@extends('profile.layout')

@section('title')
账户安全
@endsection

@section('profile-content')
<div class="container py-3">
    <nav class="nav nav-pills nav-fill row">
        <a class="nav-item nav-link  col-md-4" href="{{url('profile/account/password')}}">修改密码</a>
        <a class="nav-item nav-link col-md-4" href="{{url('profile/account/email')}}">修改邮箱</a>
        <a class="nav-item nav-link active col-md-4" href="{{url('profile/account/phone')}}">修改手机号</a>
    </nav>
</div>






@endsection