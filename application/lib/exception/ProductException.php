<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-21 18:10
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code = 404;

    public $msg = '商品不存在';

    public $errorCode = 40000 ;
}