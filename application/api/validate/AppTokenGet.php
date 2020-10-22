<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-05-12 16:13
 */

namespace app\api\validate;


class AppTokenGet extends BaseValidate
{
    protected $rule = [
        'ac' => 'require|isNotEmpty',
        'se' => 'require|isNotEmpty'
    ];
}