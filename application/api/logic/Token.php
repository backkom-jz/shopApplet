<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-22 16:21
 */

namespace app\api\logic;


class Token
{

    public static function generateToken()
    {
        // 32个随机字符
        $randChars = getRandChar(32);
        // 防伪造 3组字符串 md5加密
        $timestamp = $_SERVER['REQUEST_TIME'];
        // salt 盐
        $salt = config('secure.token_salt');

        return md5($randChars . $timestamp . $salt);
    }
}