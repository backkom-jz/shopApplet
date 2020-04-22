<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-22 11:47
 */

namespace app\api\controller\v1;


use app\api\logic\UserToken;
use app\api\validate\TokenGet;

class Token
{
    public function getToken($code = ''){
        (new TokenGet())->goCheck();
        $ut = new UserToken();
        $token = $ut->get();

        return $token;
    }
}