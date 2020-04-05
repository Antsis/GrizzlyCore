<?php
namespace app\index\model;

use think\Model;
use think\model\concern\SoftDelete;

class Game extends Model
{
    use SoftDelete;
}