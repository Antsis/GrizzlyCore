<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ url('/') }}">Grizzly</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto p">
            <li class="nav-item {{ Request::getPathInfo()=='/'?'active':'' }}">
                <a class="nav-link" href="{{ url('/') }}">主页</a>
            </li>
            <li class="nav-item {{ Request::getPathInfo()=='/bbs'?'active':'' }}">
                <a class="nav-link" href="{{ url('bbs') }}">论坛</a>
            </li>
            <li class="nav-item {{ Request::getPathInfo()=='/contact'?'active':'' }}">
                <a class="nav-link" href="{{ url('contact') }}">联系我们</a>
            </li>
            <li class="nav-item {{ Request::getPathInfo()=='/about'?'active':'' }}">
                <a class="nav-link" href="{{ url('about') }}">关于</a>
            </li>
        </ul>
        <div class="text-center">
            @if (session()->has('logined'))
                <button id="login-btn" class="btn btn-outline-success my-2 my-sm-0 p-0" type="button" onclick="window.location.href='{{url('profile/profile')}}'">
                    <img style="max-width:38px;height:auto" src="{{ asset(session()->get('logined')['avatar_url']. '_38_38.jpg')}}">
                </button>
            @else
                <button id="login-btn" class="btn btn-outline-success btn-block my-2 my-sm-0" data-toggle="modal" data-target="#modal" type="button" data-url="{{url('profile/profile')}}">登录</button>
            @endif
        </div>
    </div>
</nav>