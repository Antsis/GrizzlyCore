<?php

namespace Tests\Unit;


use Illuminate\Http\Request;

use Tests\TestCase;


class MainTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testMain(Request $request)
    {

        return time();
        


    }
}
