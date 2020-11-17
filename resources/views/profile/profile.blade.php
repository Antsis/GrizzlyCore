@extends('profile.layout')

@section('title')
个人资料
@endsection

@section('profile-content')
<div class="container py-3">
    <nav class="nav nav-pills nav-fill">
        <a class="nav-item nav-link active" href="{{url('profile/profile')}}">基本资料</a>
        <a class="nav-item nav-link" href="{{url('profile/profile/contact')}}">联系方式</a>
    </nav>
</div>


<div class="container bg-light">
    <form class="px-3">
        <div class="form-group row">
          <label for="staticId" class="col-sm-2 col-form-label">ID</label>
          <div class="col-sm-4">
            <input type="text" readonly class="form-control-plaintext" id="staticId" value="{{ $data['id'] }}">
          </div>
        </div>
        <div class="form-group row">
          <label for="staticUsername" class="col-sm-2 col-form-label">用户名</label>
          <div class="col-sm-4">
            <input type="text" readonly class="form-control-plaintext" id="staticUsername" value="{{$data['username']}}">
          </div>
        </div>

        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">姓名</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="name" value="{{$data['name']}}">
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="form-group row">
            <label for="gender" class="col-sm-2 col-form-label">性别</label>
            <div class="col-sm-2">
                <select class="custom-select mr-sm-2" id="gender">
                  <option value="0" selected>保密</option>
                  <option value="2">女</option>
                  <option value="1">男</option>
                </select>
            </div>
          </div>
        <div class="form-group row">
            <label for="birthday" class="col-sm-2 col-form-label">生日</label>
            <div class="col-sm-5">
                <div class="row">
                    <div class="col-6">
                      <input id="birthday" type="date" value="{{$data['birthday']}}">
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
            <label for="signature" class="col-sm-2 col-form-label">个性签名</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="signature">{{$data['signature']}}</textarea>
                <div class="invalid-feedback"></div>
              </div>
        </div>
        <div class="form-group row py-4">
            <div class="col text-center">
              <button id="profile-save" type="submit" class="btn btn-primary" data-purl="{{url('profile/profileSave')}}">保存</button>
            </div>
          </div>
    </form>    
</div>
@endsection