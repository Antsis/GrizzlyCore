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
            <li>权限管理RABC</li>
        </ul>
        <a class="btn btn-primary btn-lg" href="vscode:" role="button">Just do it</a>
      </div>
  </div>
@endsection
