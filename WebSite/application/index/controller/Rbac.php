<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;

class Rbac extends Controller
{

    private $p;

    public function __construct()
    {
        parent::__construct();
        $this->p = new Profile();
    }

    public function rbac()
    {
        
        $data = Db::name('role')->order(['role_id' => 'ASC'])->select();
        $this->assign('menus', $this->p->checkRole());
        $this->assign('rbac', $data);
        $this->assign('title','角色管理');
        $this->assign('data', Session::get('logined'));
        return $this->fetch();
    }
    public function add()
    {
        if ($this->request->isPost()) {
            $new_id = input('new_id');
            $data['role_name'] = input('role_name');
            $data['role_auth_ids'] = input('role_auth_ids');
            if (Db::name('role')->insert($data)){
                return $this->success('添加成功', 'rbac/rbac');
            } else {
                return $this->error('添加失败');
            }
        }
        $this->assign('data', Session::get('logined'));
        $this->assign('title', '添加权限');
        $this->assign('menus', $this->p->checkRole());
        return $this->fetch();
    }
    public function roleedit()
    {
        $id = $this->request->param("role_id");
        $role = Db::name('role')->where('role_id',$id)->select();
        if ($this->request->isPost()) {
            $new_id = input('id');
            $data['role_name'] = input('role_name');
            $data['role_auth_ids'] = input('role_auth_ids');
            if (Db::name('role')->where('role_id', $new_id)->update($data)){
                return $this->success('修改成功', 'rbac/rbac');
            } else {
                return $this->error('修改失败');
            }
        }
        $this->assign('data', Session::get('logined'));
        $this->assign('menus', $this->p->checkRole());
        $this->assign('edit',$role);
        $this->assign('title', '修改');
        $this->assign('id',$id);
        return $this->fetch();
    }
    public function roledelete()
    {
        $id = $this->request->param("role_id");
        $status = Db::name('role')->delete($id);
        if (!empty($status)) {
            $this->success("删除成功！", url('rbac/rbac'));
        } else {
            $this->error("删除失败！");
        }
    }

    public function user()
    {
        $data = Db::name('web')->order(['id' => 'ASC'])->paginate('3');
        $this->assign('user', $data);
        $this->assign('title', '用户管理');
        $this->assign('menus', $this->p->checkRole());
        $this->assign('data', Session::get('logined'));
        return $this->fetch();
    }
    public function edit()
    {
        $id = $this->request->param("id");
        if ($this->request->isPost()) {
            $new_id = input('new_id');
            $data['role_id'] = input('role_id');
            if (Db::name('web')->where('id', $new_id)->update($data)){
                return $this->success('修改成功', 'rbac/user');
            } else {
                return $this->error('修改失败');
            }
        }
        $this->assign('data', Session::get('logined'));
        $this->assign('title', '修改');
        $this->assign('id',$id);
        $this->assign('menus', $this->p->checkRole());
        return $this->fetch();
    }


    public function userDelete()
    {
        $id = $this->request->param("id", 0, 'intval');
        $status = Db::name('web')->delete($id);
        if (!empty($status)) {
            $this->success("删除成功！", url('rbac/user'));
        } else {
            $this->error("删除失败！");
        }
    }

    public function auth()
    {
        $data = Db::name('auth')->order(['auth_id' => 'ASC'])->paginate('5');
        $this->assign('data', Session::get('logined'));
        $this->assign('menus', $this->p->checkRole());
        $this->assign('auth', $data);
        $this->assign('title', '权限管理');
        return $this->fetch();
    }

    public function authedit()
    {
        $id = $this->request->param("auth_id");
        $role = Db::name('auth')->where('auth_id',$id)->select();
        if ($this->request->isPost()) {
            $new_id = input('id');
            $data['auth_name'] = input('auth_name');
            $data['auth_c'] = input('auth_c');
            $data['auth_a'] = input('auth_a');
            if (Db::name('auth')->where('auth_id', $new_id)->update($data)){
                return $this->success('修改成功', 'rbac/auth');
            } else {
                return $this->error('修改失败');
            }
        }
        $this->assign('data', Session::get('logined'));
        $this->assign('menus', $this->p->checkRole());
        $this->assign('auth',$role);
        $this->assign('title', '权限修改');
        $this->assign('id',$id);
        return $this->fetch();
    }
    public function authdelete()
    {
        $id = $this->request->param("auth_id");
        $status = Db::name('auth')->delete($id);
        if (!empty($status)) {
            $this->success("删除成功！", url('rbac/auth'));
        } else {
            $this->error("删除失败！");
        }
    }
    public function authadd()
    {
        if ($this->request->isPost()) {
            $data['auth_name'] = input('auth_name');
            $data['auth_c'] = input('auth_c');
            $data['auth_a'] = input('auth_a');
            if (Db::name('auth')->insert($data)){
                return $this->success('添加成功', 'rbac/auth');
            } else {
                return $this->error('添加失败');
            }
        }
        $this->assign('data', Session::get('logined'));
        $this->assign('menus', $this->p->checkRole());
        $this->assign('title', '添加权限');
        return $this->fetch();
    }
    public function topic_manage()
    {
        $this->assign('data', Session::get('logined'));
        $this->assign('menus', $this->p->checkRole());
        $this->assign('title', '帖子管理');
        return view();
    }
}
