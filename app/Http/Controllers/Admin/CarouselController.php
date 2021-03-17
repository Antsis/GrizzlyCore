<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarouselController extends Controller
{
    //
    public function getCarousel()
    {
        # code...
        DB::table('banners')->where('')
    }
}
