<?php

namespace Tests\Unit;

use App\Mail\AccountSecurity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;


class MainTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testMain()
    {
        $emailCode = "";
        for($i=0;$i<6;$i++){
            $emailCode .= rand(0, 9);
        }
        return Mail::to('707636381@qq.com')->send(new AccountSecurity($emailCode));

    }
}
