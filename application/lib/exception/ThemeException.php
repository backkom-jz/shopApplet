<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-21 17:00
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code = 404;

    public $msg = '请求的Theme不存在';

    public $errorCode = 40000 ;
}