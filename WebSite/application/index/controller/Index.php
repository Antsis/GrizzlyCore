<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {

        $this->assign("index","1");
        $this->assign("news","0");
        $this->assign("picture","0");
        $this->assign("about","0");
        $this->assign("contact","0");
        return $this->fetch();

    }
    
    public function news()
    {
        $this->assign("index","0");
        $this->assign("news","1");
        $this->assign("picture","0");
        $this->assign("about","0");
        $this->assign("contact","0");
        return $this->fetch();
    }

    public function about()
    {
        $this->assign("index","0");
        $this->assign("news","0");
        $this->assign("picture","0");
        $this->assign("about","1");
        $this->assign("contact","0");
        return $this->fetch();
    }

    public function contact()
    {
        $this->assign("index","0");
        $this->assign("news","0");
        $this->assign("picture","0");
        $this->assign("about","0");
        $this->assign("contact","1");
        return $this->fetch();
    }

    public function picture()
    {
        $this->assign("index","0");
        $this->assign("news","0");
        $this->assign("picture","1");
        $this->assign("about","0");
        $this->assign("contact","0");
        return $this->fetch();
    }

}
