<?php

namespace app\api\validate;

use app\lib\exception\BaseException;
use think\Exception;
use think\facade\Request;
use think\Validate;

/**
 * Class BaseValidate
 * 验证类的基类
 */
class BaseValidate extends Validate
{

    /**
     * 检测所有客户端发来的参数是否符合验证类规则
     * 基类定义了很多自定义验证方法
     * 这些自定义验证方法其实，也可以直接调用
     * @throws Exception
     * @return true
     */
    public function goCheck()
    {
        //必须设置contetn-type:application/json
        $params = Request::param();
        if (!$this->check($params)) {
            $exception = $this->error;
            throw new BaseException($exception);
        }
        return true;
    }


    protected function isPositiveInteger($value, $rule='', $data='', $field='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
//        return $field . '必须是正整数';
        return false;
    }

}