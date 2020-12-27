@extends('common.layout')

@section('title')
后台管理
@endsection

@section('nav')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
    <a class="navbar-brand" href="{{url('admin/index')}}">Admin 系统管理</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse flex-row-reverse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item ">
                <a class="nav-link" href="{{url('/')}}">返回网站</a>
            </li>
        </ul>
    </div>
    </nav>
@endsection


@section('maintext')
    <div class="container-xl my-2">
        <div class="row">
            <div class="col-2">
            <div class="list-group">
            <button type="button" class="list-group-item list-group-item-action admin-btn-a {{ Request::getPathInfo() == '/admin/index' ? 'active text-light' : '' }}" data-url="{{url('admin/index')}}">首页</button>
            <button type="button" class="list-group-item list-group-item-action admin-btn-a {{ Request::getPathInfo() == '/admin/user' ? 'active text-light' : '' }}" data-url="{{url('admin/user')}}">用户管理</button>
            <button type="button" class="list-group-item list-group-item-action admin-btn-a {{ Request::getPathInfo() == '/admin/role' ? 'active text-light' : '' }}" data-url="{{url('admin/role')}}">角色管理</button>
            <button type="button" class="list-group-item list-group-item-action admin-btn-a {{ Request::getPathInfo() == '/admin/access' ? 'active text-light' : '' }}" data-url="{{url('admin/access')}}">权限管理</button>
            </div>
            </div>
            <div class="col-10">
                @section('childtext')
                    
                @show
            </div>
        </div>
    </div>
   
@endsection

@section('footer')
@endsection

@section('js')
    {{-- <script src="{{ asset('static/js/admin.js') }}"></script> --}}
    {{-- <script src="{{ asset('static/js/admin/user.js') }}"></script> --}}
    {{-- <script src="{{ asset('static/js/admin/role.js') }}"></script> --}}
    {{-- <script src="{{ asset('static/js/admin/index.js') }}"></script> --}}
    {{-- <script src="{{ asset('static/js/admin/access.js') }}"></script> --}}

    <script src="{{ mix('/js/admin.js') }}"></script>

@endsection