<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();

    }
    
    public function news()
    {
        return $this->fetch();
    }

    public function about()
    {
        return $this->fetch();
    }

    public function contact()
    {
        return $this->fetch();
    }

    public function picture()
    {
        return $this->fetch();
    }

    public function login()
    {
        return $this->fetch();
    }

    public function register()
    {
        return $this->fetch();
    }

}
