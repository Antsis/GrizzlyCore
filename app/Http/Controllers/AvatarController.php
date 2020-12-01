<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use SplFileInfo;

class AvatarController extends Controller
{
    /**
     * 生成头像, 默认尺寸200px
     */
    public function index(Request $request, $md5)
    {
        header('Content-type: image/png');
        $size = null;
        if($request->has('s')){
           $size = $request->input('s'); 
        }else $size = 200;
        $path = "avatar/$md5.jpg";
        if(!is_file($path)){
            return response()->json(['error' => ['code' => '001', 'message' => 'path is not a file']]);
        }
        $info = getimagesize($path);
        $new_im = imagecreatetruecolor($size, $size);

        // return dump($new_im);
        $im = imagecreatefromjpeg($path);
        imagecopyresampled($new_im, $im, 0, 0, 0, 0, $size, $size, $info[0], $info[1]);
        // imageinterlace($new_im, 1);

        // imagepng($new_im);

        return response(imagepng($new_im))->header('Content-type', 'image/png');
        imagedestroy($new_im);
    }

    /**
     * Get a file of SplFileInfo Object
     *
     * @param string $path
     * @return SplFileInfo
     */
    public function getSplFile($path)
    {
        if(is_file($path)){
            return new \SplFileInfo($path);
        }

        throw new FileNotFoundException("File does not exist at path {$path}.");
    }
}
