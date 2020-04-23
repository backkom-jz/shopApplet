<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-22 11:47
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\logic\UserToken;
use app\api\validate\TokenGet;

class Token extends BaseController
{
    public function getToken($code = '')
    {
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();

        return [
            'token' => $token
        ];
    }
}