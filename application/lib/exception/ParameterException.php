<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-23 16:49
 */

namespace app\lib\exception;


/**
 * Class ParameterException
 * 通用参数类异常错误
 */
class ParameterException extends BaseException
{
    public $code = 400;

    public $errorCode = 10000;

    public $msg = "invalid parameters";
}