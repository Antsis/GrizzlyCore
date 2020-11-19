@extends('common.layout')

@section('title')
后台管理
@endsection

@section('nav')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
    <a class="navbar-brand" href="{{url('admin/index')}}">Admin</a>
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

@section('footer')

@endsection

@section('maintext')
    <div class="container-xl my-2">
        <div class="row">
            <div class="col-2">
            <div class="list-group">
            <button type="button" disabled  class="list-group-item list-group-item-action active">
                About
            </button>
            <button type="button" class="list-group-item list-group-item-action" data-url="{{url(">用户管理</button>
            <button type="button" class="list-group-item list-group-item-action" >角色管理</button>
            <button type="button" class="list-group-item list-group-item-action">权限管理</button>
            </div>
            </div>
            <div class="col-10">
                @section('childtext')
                    <h1>Grizzly网站的后台管理</h1>
                @show
            </div>
        </div>
    </div>
   
    
@endsection
