<?php
/**
 * Created by PhpStorm.
 * User: wangjz
 * Date: 2020-03-23
 * Time: 23:31
 */

namespace app\lib\exception;


use think\Exception;
use think\exception\Handle;
use think\facade\Log;
use think\facade\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    public function render(\Exception $e)
    {
        if ($e instanceof BaseException) {
            // 如果是自定义异常
            $this->code = $e->code;
            $this->msg = $e->getMessage()?:$e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            if(config('app_debug')){
                return parent::render($e);
            }
            // 系统异常
            $this->code = 500;
            $this->msg = 'sorry，we make a mistake. (^o^)Y';
            $this->errorCode = 999;
            $this->recordErrorLog($e);
        }
        $request = Request::url();
        $result = [
            'msg' => $this->msg,
            'errorCode' => $this->errorCode,
            'request_url' => $request
        ];
        return json($result,$this->code);
    }

    /*
     * 将异常写入异常
     */
    public function recordErrorLog(Exception $e){
        Log::init([
            'type' =>'File',
            'path' => LOG_PATH,
            'level' =>['sql'],
            ]);
        Log::record($e->getMessage(),'error');
    }
}