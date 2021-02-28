@extends('index.layout')

@section('title')
Grizzly
@endsection

@section('maintext')
@parent
<div class="container">
    <div class="jumbotron my-4">
        <h1 class="display-4">Hello, world!</h1>
        <p class="lead">这是我用来学习WEB相关技术的案例.</p>
        <hr class="my-4">
        <h5>todo</h5>
        <ul>
            <li>论坛功能</li>
            <li>电商功能</li>
            <li>聊天系统</li>
            <li>图片上传的太卡, 会造成浏览器性能问题, 每次调取头像时, php读取头像分辨率过大会造成性能问题, 导航栏需要静态头像资源, 上传到服务器的头像需要进行压缩</li>
            <li>上传图片后使用队列处理</li>
        </ul>
        <a class="btn btn-primary btn-lg" href="vscode:" role="button">Just do it</a>
      </div>
  </div>
@endsection
