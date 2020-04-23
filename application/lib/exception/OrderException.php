<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-23 17:16
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;

    public $msg = '订单不存在，请检查ID';

    public $errorCode = 80000;
}