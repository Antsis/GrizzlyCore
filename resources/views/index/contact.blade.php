@extends('index.layout')


@section('title')
联系我们
@endsection


@section('maintext')
    @parent
    <div class="container">
        <div class="jumbotron my-4">
            <h1 class="display-4">联系我们</h1>
            <p class="lead">....</p>
            <hr class="my-4">
            <h5>联系方式</h5>
            <ul>
                <li>邮箱</li>
                <li>qq</li>
                <li>微信</li>
            </ul>
            <a class="btn btn-primary btn-lg" href="vscode:" role="button">Just do it</a>
          </div>
      </div>
@endsection
