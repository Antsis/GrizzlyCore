<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $token =

    }




    /**
     * 成功
     *
     * @param mixed $result
     * @return void
     */
    public function success($result = '')
    {
        return response()->json(['status' => 'success', 'data' => $result ]);
    }

    /**
     * 失败返回
     *
     * @param string $msg
     * @return void
     */
    public function fail($msg = '')
    {
        return response()->json(['status' => 'fail', 'data' => $msg]);
    }
}
