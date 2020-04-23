<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-23 10:47
 */

namespace app\lib\exception;


/*
 *  token验证失败时抛出此异常
 */
class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不够';
    public $errorCode = 10001;
}