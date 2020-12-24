<?php

namespace Tests\Unit;

use App\Models\AccessLog;
use Illuminate\Http\Request;

use Tests\TestCase;


class MainTest extends TestCase
{
    protected $s;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testMain(Request $request)
    {
        
        $log = new AccessLog();
                $log->uid = 1;
                $log->target_url = $request->fullUrl();
                $log->http_type = $request->method();
                $log->ip = $request->ip();
                $log->ua = $request->server('HTTP_USER_AGENT');
                $log->created_at = now('+8:00');
                $log->save();
    }


}
