<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-22 15:44
 */

namespace app\api\model;


class User extends BaseModel
{

    protected $autoWriteTimestamp = true;
//    protected $createTime = ;

    public function orders()
    {
        return $this->hasMany('Order', 'user_id', 'id');
    }

    public function address()
    {
        return $this->hasOne('UserAddress', 'user_id', 'id');
    }

    public static function getByOpenId($openId)
    {
        $user = User::where('openid', $openId)
            ->find();
        return $user;
    }
}