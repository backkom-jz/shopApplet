<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-05-10 11:11
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;

class Pay extends BaseController
{
    protected $beforeActionList = [];

    public function getPreOrder($id = ''){
        (new IDMustBePositiveInt())->goCheck();
        $pay =
    }
}