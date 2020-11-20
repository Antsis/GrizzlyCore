@extends('admin.layout')

@section('title')
角色管理
@endsection

@section('childtext')
    <div class="container bg-light">
        <div class="row">
            <div class="col my-2"><h4>角色列表</h4></div>
            <div class="col text-right px-2 my-2"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addRoleModal"">添加角色</button></div>
        </div>
        <div class="row">
            <table class="table table-striped text-center">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">角色名</th>
                        <th scope="col">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <th scope="row">{{ $role->id}}</th>
                            <td>{{ $role->name }}</td>
                            <td>
                                <a href="#" class="role-delete" data-url="{{url('admin/role')}}" data-id="{{ $role->id }}">删除</a> 
                                <a href="#editRoleModal" data-toggle="modal" data-target="#editRoleModal" data-id="{{ $role->id }}" data-name="{{ $role->name }}">编辑</a>
                                <a href="#">设置权限</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row d-flex justify-content-center">
            {{ $roles }}
        </div>
    </div>

    <!-- 添加模态框 -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoleModal">新的角色</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                <div class="form-group">
                    <label for="role-name-add" class="col-form-label">角色名:</label>
                    <input type="text" class="form-control" id="role-name-add">
                    <div class="invalid-feedback"></div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                <button id="role-add" type="button" class="btn btn-primary" data-url="{{url('admin/role')}}">提交</button>
            </div>
            </div>
        </div>
    </div>

    <!-- 编辑模态框 -->
    <div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-labelledby="editRoleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModal">编辑角色ID: <span id="role-id"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                <div class="form-group">
                    <label for="role-name-edit" class="col-form-label">角色名:</label>
                    <input type="text" class="form-control" id="role-name-edit">
                    <div class="invalid-feedback"></div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                <button id="role-edit" type="button" class="btn btn-primary" data-url="{{url('admin/role')}}">提交</button>
            </div>
            </div>
        </div>
    </div>
@endsection

