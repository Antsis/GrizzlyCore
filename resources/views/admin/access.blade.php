@extends('admin.layout')

@section('title')
权限管理
@endsection

@section('childtext')
    <div class="container bg-light">
        <div class="row">
            <div class="col my-2"><h4>权限列表</h4></div>
            <div class="col text-right px-2 my-2"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAccessModal"">添加权限</button></div>
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
                    @foreach ($access_list as $access)
                        <tr>
                            <th scope="row" class="align-middle">{{ $access->id}}</th>
                            <td class="align-middle">{{ $access->name }}</td>
                            <td class="align-middle">{!! implode("<br>", json_decode($access->urls)) !!}</td>
                            <td class="align-middle">
                                <a href="#" class="access-delete" data-url="{{url('admin/access')}}" data-id="{{ $access->id }}">删除</a> 
                                <a href="#editAccessModal" data-toggle="modal" data-target="#editAccessModal" data-id="{{ $access->id }}" data-name="{{ $access->name }}" data-urls="{{ implode("\n", json_decode($access->urls)) }}">编辑</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row d-flex justify-content-center">
            {{ $access_list }}
        </div>
    </div>

    <div class="test">
    </div>

    <!-- add access modal-->
    <div class="modal fade" id="addAccessModal" tabindex="-1" role="dialog" aria-labelledby="addAccessModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">新的权限</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="access-name-add" class="col-form-label">权限名:</label>
                        <input type="text" class="form-control" id="access-name-add">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="access-urls-add">Urls</label>
                        <textarea class="form-control" id="access-urls-add"" rows="4" placeholder="一行一个Url&#10;例如/index/index"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                <button id="access-add" type="button" class="btn btn-primary" data-url="{{url('admin/access')}}">提交</button>
            </div>
            </div>
        </div>
    </div>

    <!-- edit access modal -->
    <div class="modal fade" id="editAccessModal" tabindex="-1" role="dialog" aria-labelledby="editAccessModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">修改的权限ID: <span id="access-id"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="access-name-edit" class="col-form-label">权限名:</label>
                        <input type="text" class="form-control" id="access-name-edit">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="access-urls-edit">Urls</label>
                        <textarea class="form-control" id="access-urls-edit"" rows="4" placeholder="一行一个Url&#10;例如/index/index"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                <button id="access-edit" type="button" class="btn btn-primary" data-url="{{url('admin/access')}}">提交</button>
            </div>
            </div>
        </div>
    </div>
@endsection

