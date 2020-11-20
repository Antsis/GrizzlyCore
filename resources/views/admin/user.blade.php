@extends('admin.layout')

@section('title')
用户管理
@endsection

@section('childtext')
<div class="container bg-light">
        <div class="row">
            <div class="col my-2"><h4>角色列表</h4></div>
        </div>
        <div class="row">
            <table class="table table-striped text-center">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">用户名</th>
                        <th scope="col">邮箱</th>
                        <th scope="col">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id}}</th>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="#" class="user-delete" data-url="{{url('admin/user')}}" data-id="{{ $user->id }}">删除</a> 
                                <a href="#editUserModal" data-toggle="modal" data-target="#editUserModal" data-id="{{ $user->id }}" data-name="{{ $user->username }}" data-email="{{$user->email}}">编辑</a>
                                <a href="#">设置角色</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row d-flex justify-content-center">
            {{ $users }}
        </div>
    </div>

    <!-- 编辑模态框 -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModal">编辑用户ID: <span id="user-id"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                <div class="form-group">
                    <label for="user-name-edit" class="col-form-label">用户名:</label>
                    <input type="text" class="form-control" id="user-name-edit">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="user-email-edit" class="col-form-label">邮箱:</label>
                    <input type="text" class="form-control" id="user-email-edit">
                    <div class="invalid-feedback"></div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                <button id="user-edit" type="button" class="btn btn-primary" data-url="{{url('admin/user')}}">提交</button>
            </div>
            </div>
        </div>
    </div>

    <!-- 设置角色模态框 -->
    <div class="modal fade" id="editUserRoleModal" tabindex="-1" role="dialog" aria-labelledby="editUserRoleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserRoleModal">编辑用户ID: <span id="user-id"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                <div class="form-group">
                    <label for="user-name-edit" class="col-form-label">用户名:</label>
                    <input type="text" class="form-control" id="user-name-edit">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="user-email-edit" class="col-form-label">邮箱:</label>
                    <input type="text" class="form-control" id="user-email-edit">
                    <div class="invalid-feedback"></div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                <button id="user-edit" type="button" class="btn btn-primary" data-url="{{url('admin/user')}}">提交</button>
            </div>
            </div>
        </div>
    </div>

@endsection

