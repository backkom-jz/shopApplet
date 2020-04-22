<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-22 11:55
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];

    protected $message=[
        'code' => 'no code no token'
    ];
}