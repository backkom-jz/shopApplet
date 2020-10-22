<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-22 15:07
 */

namespace app\lib\exception;


class WechatException extends BaseException
{
    public $code = 400;

    public $msg = 'wechat unknown error';

    public $errorCode = 999;
}