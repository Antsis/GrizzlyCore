@extends('common.layout')

@section('meta')
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Cache" content="no-cache">
@endsection

@section('maintext')
    <div class="container-xl">
        <div class="row my-4">
            <div class="col-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{url('/')}}">
                        <svg class="bi bi-house" width="1em" height="1em" viewbox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                            <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                          </svg>
                      </a></li>
                      <li class="breadcrumb-item"><a href="{{url('profile/profile')}}">设置</a></li>
                      <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
                    </ol>
                  </nav>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <ul class="list-group text-center">
                    <li class="list-group-item text-black-50">设置</li>
                    <li class="list-group-item {{ Request::getPathInfo() == '/profile/avatar' ? 'active text-light' : '' }}"><a class="{{ Request::getPathInfo() == '/profile/avatar' ? 'text-light' : '' }}" href="{{url('profile/avatar')}}">修改头像</a></li>
                    <li class="list-group-item {{ Request::getPathInfo() == '/profile/profile' || Request::getPathInfo() == '/profile/profile/contact' ? 'active text-light' : '' }}"><a class="{{ Request::getPathInfo() == '/profile/profile' || Request::getPathInfo() == '/profile/profile/contact' ? 'text-light' : '' }}" href="{{url('profile/profile')}}">个人资料</a></li>
                    <li class="list-group-item {{ Request::getPathInfo() == '/profile/account' ? 'active text-light' : '' }}"><a class="{{ Request::getPathInfo() == '/profile/account' ? 'text-light' : '' }}" href="{{url('profile/account')}}">账户安全</a></li>
                    <li class="list-group-item "><a href="{{url('login/logout')}}">退出登录</a></li>
                </ul>
            </div>
            <div class="col-10">
                <div class="bg-light shadow-sm">
                    @section('profile-content')

                    @show
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('static/js/profile.js') }}"></script>
@endsection