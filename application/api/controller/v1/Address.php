<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-22 18:29
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\AddressNew;
use think\Controller;

class Address extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress,getUserAddress']
    ];

    public function createOrUpdateAddress(){
        $Validate = new AddressNew();
        $Validate->goCheck();
    }
}