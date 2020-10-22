<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-22 16:21
 */

namespace app\api\logic;


use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\ParameterException;
use app\lib\exception\TokenException;
use think\Exception;
use \think\facade\Request;
use \think\facade\Cache;

class Token
{
    /*
     * 生成token令牌
     */
    public static function generateToken()
    {
        // 32个随机字符
        $randChars = getRandChar(32);
        // 防伪造 3组字符串 md5加密
        $timestamp = $_SERVER['REQUEST_TIME'];
        // salt 盐
        $salt = config('secure.token_salt');

        return md5($randChars . $timestamp . $salt);
    }


    //验证token是否合法或者是否过期
    //验证器验证只是token验证的一种方式
    //另外一种方式是使用行为拦截token，根本不让非法token
    //进入控制器
    public static function needPrimaryScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope >= ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    /*
     * 用户专有权限
     */
    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope == ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    /*
     * 超级管理员权限
     */
    public static function needSuperScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope == ScopeEnum::Super) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    /*
     * 获取当前token
     */
    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()
            ->header('token');
        $vars = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        } else {
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            } else {
                throw new Exception('尝试获取的Token变量并不存在');
            }
        }
    }


    /*
     * 获取当前的UID
     * 当需要获取全局UID时，应当调用此方法
     * 而不应当自己解析UID
     */
    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar('uid');
        $scope = self::getCurrentTokenVar('scope');
        if ($scope == ScopeEnum::Super) {
            // 只有Super权限才可以自己传入uid
            // 且必须在get参数中，post不接受任何uid字段
            $userID = input('get.uid');
            if (!$userID) {
                throw new ParameterException(
                    [
                        'msg' => '没有指定需要操作的用户对象'
                    ]);
            }
            return $userID;
        } else {
            return $uid;
        }
    }

    /*
     * 检测UID是否匹配
     */
    public static function isValidateOperate($checkUID)
    {
        if (!$checkUID) {
            throw new Exception('检测UID 必须传入一个被检测的UID');
        }
        $currentOperateUid = self::getCurrentUid();
        if ($currentOperateUid == $checkUID) {
            return true;
        }
        return false;
    }

    /*
     * 检测token是否合法
     */
    public static function verifyToken($token)
    {
        $exist = Cache::get($token);
        if($exist){
            return true;
        }
        else{
            return false;
        }
    }
}