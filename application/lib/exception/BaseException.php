<?php
/**
 * Created by PhpStorm.
 * User: wangjz
 * Date: 2020-03-23
 * Time: 23:33
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    // HTTP状态码
    public $code = 400;

    // 错误具体信息
    public $msg = 'invalid parameters';

    // 自定义状态码
    public $errorCode = 999;

    public $shouldToClient = true;

//
//    public function __construct($params=[])
//    {
//        if(!is_array($params)){
//            return;
//        }
//        if(array_key_exists('code',$params)){
//            $this->code = $params['code'];
//        }
//        if(array_key_exists('msg',$params)){
//            $this->msg = $params['msg'];
//        }
//        if(array_key_exists('errorCode',$params)){
//            $this->errorCode = $params['errorCode'];
//        }
//    }
}