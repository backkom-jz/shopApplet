<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-05-12 16:09
 */

namespace app\api\logic;


use app\api\model\ThirdApp as ThirdAppModel;
use app\lib\exception\TokenException;

class AppToken extends Token
{
    public function get($ac, $se)
    {
        $app = ThirdAppModel::check($ac, $se);
        if(!$app)
        {
            throw new TokenException([
                'msg' => '授权失败',
                'errorCode' => 10004
            ]);
        }
        else{
            $scope = $app->scope;
            $uid = $app->id;
            $values = [
                'scope' => $scope,
                'uid' => $uid
            ];
            $token = $this->saveToCache($values);
            return $token;
        }
    }

    /*
     * 保存到服务器缓存
     */
    private function saveToCache($values){
        $token = self::generateToken();
        $expire_in = config('setting.token_expire_in');
        $result = cache($token, json_encode($values), $expire_in);
        if(!$result){
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $token;
    }
}