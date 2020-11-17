<?php
/**
 * 公共函数
 */

namespace App\Http\Controllers;

class Common
{
    /**
     * 生成随机码
     * 
     * @param integer $length=16 随机码的长度
     * @param bool $strup=true 字母是否大写
     */
    static public function getRandCode($length = 16, $strup = true)
    {
        return ($strup)?strtoupper(bin2hex(random_bytes($length))):bin2hex(random_bytes($length));
    }
    
}