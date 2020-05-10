<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-05-10 11:11
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;
use app\api\logic\Pay as PayLogic;
use app\api\logic\WxNotify as WxNotifyLogic;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];

    public function getPreOrder($id = ''){
        (new IDMustBePositiveInt())->goCheck();
        $pay = new PayLogic($id);
        return $pay->pay();
    }

    public function redirectNotify()
    {
        $notify = new WxNotifyLogic();
        $notify->handle();
    }

    public function notifyConcurrency()
    {
        $notify = new WxNotifyLogic();
        $notify->handle();
    }

    public function receiveNotify()
    {
        // 通知频率为15/15/30/180/1800/1800/3600 ，单位：秒

        // 1  检查库存，超卖
        // 2 更新这个订单的statsu状态
        // 3 减库存
        // 4 如果成功处理，我们返回微信成功处理的信息 否则 我们返回没有成功处理
//        $xmlData = file_get_contents('php://input');
//        Log::error($xmlData);
        $notify = new WxNotifyLogic();
        $notify->handle();
//        $xmlData = file_get_contents('php://input');
//        $result = curl_post_raw('http:/zerg.cn/api/v1/pay/re_notify?XDEBUG_SESSION_START=13133',
//            $xmlData);
//        return $result;
//        Log::error($xmlData);
    }
}