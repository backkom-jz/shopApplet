<?php
/**
 * Created by PhpStorm.
 * User: wangjz
 * Date: 2020-03-23
 * Time: 23:38
 */

namespace app\lib\exception;



class BannerMissException extends BaseException
{
    public $code = 404;

    public $msg = '请求的banner不存在';

    public $errorCode = 40000 ;
}