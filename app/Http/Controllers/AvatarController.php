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
        $path = "./avatar/$md5.jpg";
        if(!is_file($path)){
            return response()->json(['error' => ['code' => '001', 'message' => 'path is not a file']]);
        }
        $ext = mime_content_type($path);


        // return dump($ext);
        $info = getimagesize($path);
        $new_im = imagecreatetruecolor($size, $size);


        // 头像类型处理
        if($ext == 'image/jpeg' || $ext == 'image/jpg' ){
            $im = imagecreatefromjpeg($path);
        }else if($ext == 'image/png'){
            $im = imagecreatefrompng($path);
        }else if($ext == 'image/gif' ){
            $im = imagecreatefromgif($path);
        }else{
            return abort(406, 'Type is error!');
        }

        if(!imagecopyresampled($new_im, $im, 0, 0, 0, 0, $size, $size, $info[0], $info[1])){
            return response()->json(['error' => ['code' => '002', 'message' => 'Generative Failure!']]);
        }

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
