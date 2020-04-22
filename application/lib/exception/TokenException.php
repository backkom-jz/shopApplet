<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-22 11:54
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;

    public $msg = 'Token已过期或无效Token';

    public $errorCode = 10001;
}