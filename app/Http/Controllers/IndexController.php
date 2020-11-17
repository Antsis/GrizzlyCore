<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Web;
use Illuminate\Support\Facades\Cookie;

class IndexController extends Controller
{
    public function index()
    {
        return view('index.index');
    }

    public function about()
    {
        return view('index.about');
    }

    public function bbs()
    {
        return view('index.bbs');
    }

    public function contact()
    {
        if(session()->has('logined')){
            return view('index.contact', [
                'data' => $this->updateData()
            ]);
        }else{
            return view('index.contact');
        }    }

    public function checkLogined()
    {
        if(session()->get('logined')!=null){
            return response()->json(['error'=>['code'=>1, 'message'=>'Logged in']]);
        }else{
            return response()->json(['error'=>['code'=>0, 'message'=>'unlogged']]);
        }
    }

    public function logout(Request $request)
    {
        session()->flush();
        Cookie::queue(Cookie::forget('login_token'));
        return redirect('/');
    }

    public function updateData()
    {
        return Web::find(session()->get('logined')['id'])->toArray();
    }
    
}
