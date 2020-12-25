@extends('profile.layout')

@section('title')
个人资料
@endsection

@section('profile-content')
<div class="container py-3">
    <nav class="nav nav-pills nav-fill row">
        <a class="nav-item nav-link active col-sm-6" href="{{url('profile/index')}}">基本资料</a>
        <a class="nav-item nav-link col-sm-6" href="{{url('profile/contact')}}">联系方式</a>
    </nav>
</div>


<div class="container bg-light">
    <form class="px-3">
        <div class="form-group row">
          <label for="staticId" class="col-2 col-form-label">ID</label>
          <div class="col-4">
            <input type="text" readonly class="form-control-plaintext" id="staticId" value="{{ $user->id }}">
          </div>
        </div>
        <div class="form-group row">
          <label for="staticUsername" class="col-sm-2 col-form-label">用户名</label>
          <div class="col-sm-4">
            <input type="text" readonly class="form-control-plaintext" id="staticUsername" value="{{ $user->username }}">
          </div>
        </div>

        <div class="form-group row">
          <label for="name" class="col-md-2 col-form-label">姓名</label>
          <div class="col-md-4">
            <input type="text" class="form-control" id="name" value="{{ $user->name }}">
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="form-group row">
            <label for="gender" class="col-md-2 col-form-label">性别</label>
            <div class="col-md-2">
                <select class="custom-select mr-md-2" id="gender" >
                  @foreach ($genders as $gender)
                    <option value="{{ $loop->index }}" @if ( $user->gender == $loop->index ) selected @endif >{{$gender}}</option>
                  @endforeach
                </select>
            </div>
          </div>
        <div class="form-group row">
            <label for="birthday" class="col-md-2 col-form-label">生日</label>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-6">
                      <input id="birthday" type="date" value="{{ $user->birthday }}" min="1970-01-02" max="2038-01-01">
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="form-group row">
            <label for="province" class="col-sm-2 col-form-label">地区</label>
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-6">
                        <select class="custom-select mr-sm-2" id="province">
                            <option selected>省</option>
                          </select>
                      </div>
                      <div class="col">
                        <select class="custom-select mr-sm-2" id="city">
                            <option selected>市/县</option>
                          </select>
                      </div>
                      <div class="col">
                        <select class="custom-select mr-sm-2" id="area">
                            <option selected>区</option>
                          </select>
                      </div>
                </div>
            </div>
          </div> -->
        <div class="form-group row">
            <label for="signature" class="col-md-2 col-form-label">个性签名</label>
            <div class="col-md-10">
                <textarea class="form-control" id="signature">{{ $user->signature }}</textarea>
                <div class="invalid-feedback"></div>
              </div>
        </div>
        <div class="form-group row py-4">
            <div class="col text-center ">
              <button id="profile-save" type="submit" class="btn btn-primary col-md-2 col-sm-8 " data-purl="{{url('profile/index')}}">保存</button>
            </div>
          </div>
    </form>    
</div>
@endsection
