@extends('admin.layout')

@section('title')
权限管理
@endsection

@section('childtext')
    <div class="container bg-light">
        <div class="row">
            <div class="col my-2"><h4>权限列表</h4></div>
            <div class="col text-right px-2 my-2"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addRoleModal"">添加角色</button></div>
        </div>
        <div class="row">
            <table class="table table-striped text-center">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">权限名</th>
                        <th scope="col">Urls</th>
                        <th scope="col">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $access)
                        <tr>
                            <th scope="row">{{ $access->id}}</th>
                            <td>{{ $access->name }}</td>
                            <td>{{ $access->urls }}</td>
                            <td>
                                <a href="#" class="access-delete" data-url="{{url('admin/access')}}" data-id="{{ $access->id }}">删除</a> 
                                <a href="#editRoleModal" data-toggle="modal" data-target="#editRoleModal" data-id="{{ $role->id }}" data-name="{{ $role->name }}">编辑</a>
                                <a href="#">设置权限</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row d-flex justify-content-center">
            {{ $access }}
        </div>
    </div>
@endsection

