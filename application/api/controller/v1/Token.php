<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-22 11:47
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\logic\AppToken as AppTokenLogic;
use app\api\logic\UserToken as UserTokenLogic;
use app\api\logic\Token as TokenLogic;
use app\api\validate\AppTokenGet;
use app\api\validate\TokenGet;
use app\lib\exception\ParameterException;

class Token extends BaseController
{
    public function getToken($code = '')
    {
        (new TokenGet())->goCheck();
        $ut = new UserTokenLogic($code);
        $token = $ut->get();

        return json(['token'=>$token]);
    }

    /**
     * 第三方应用获取令牌
     * @url /app_token?
     * @POST ac=:ac se=:secret
     */
    public function getAppToken($ac='', $se='')
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET');
        (new AppTokenGet())->goCheck();
        $app = new AppTokenLogic();
        $token = $app->get($ac, $se);
        return [
            'token' => $token
        ];
    }

    public function verifyToken($token='')
    {
        if(!$token){
            throw new ParameterException([
                'token不允许为空'
            ]);
        }
        $valid = TokenLogic::verifyToken($token);
        return json([
            'isValid' => $valid
        ]);
    }
}