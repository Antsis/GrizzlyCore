@extends('profile.layout')

@section('title')
修改头像
@endsection
@section('profile-content')
<div class="container bg-light shadow-sm">
        <div class="row-cols-1 py-2">
            <h4>当前的头像</h4>
            <small>如果您还没有设置自己的头像，系统会显示为默认头像，您需要自己上传一张新照片来作为自己的个人头像</small>
            <div class="my-4" style="max-width:200px;height:200px">
                <img class="border border-dark" style="width: 100%;height: auto;" src="{{ asset($data['avatar_url']. '_200_200.jpg') }}" alt="头像">
            </div>
        </div>
        <div class="row-cols-1">
            <h4>设置新头像</h4>
            <small>请选择一个新照片进行上传编辑</small>
            <br>
            <small>头像保存后，您可能需要刷新一下本页面(按F5键)，才能查看最新的头像效果</small>
            <form>
                <div class="custom-file my-4">
                    <input type="file" name class="custom-file-input" id="avatar" >
                    <label class="custom-file-label col-6" for="customFile"  data-browse="浏览">选择文件</label>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="text-center col-6 pb-4">
                    <button id="avatar-upload" class="btn btn-primary col-3 text-center" type="submit" data-purl="{{url('profile/avatarUpload')}}">上传</button>
                </div>
            </form> 
        </div>

    </div>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">提示</h5>
                <button type="button" id="close-btn" class="close" data-dismiss="modal" aria-label="Close" data-url="{{url('profile/avatar')}}">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>图片上传成功</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" id="close-btn2" class="btn btn-primary" data-dismiss="modal" data-url="{{url('profile/avatar')}}">完成</button>
            </div>
        </div>
        </div>
    </div>
@endsection