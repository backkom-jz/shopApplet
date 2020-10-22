<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-23 17:42
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;

    public $msg = '用户不存在';

    public $errorCode = 60000;
}