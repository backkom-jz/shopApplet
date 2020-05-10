<?php
/**
 * Created by PhpStorm.
 * Note: 支付接口
 * User: 凸^-^凸
 * Date:  2020-05-10 11:21
 */

namespace app\api\logic;


use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use app\api\model\Order as OrderModel;
use app\api\logic\Token as TokenLogic;
use think\Exception;
use think\facade\Log;

require_once('../extend/WxPay/WxPay.Api.php');
require_once('../extend/WxPay/WxPay.Config.php');
class Pay
{
    private $orderNo;
    private $orderID;

    public function __construct($orderID)
    {
        if (!$orderID) {
            throw new Exception('订单号不允许为NULL');
        }
        $this->orderID = $orderID;
    }

    public function pay()
    {
        $this->checkOrderValid();
        // 库存量检测
        $OrderLogic = new Order();
        $status = $OrderLogic->checkOrderStock($this->orderID);
        if (!$status['pass']) {
            return $status;
        }
        return $this->makeWxPreOrder($status['orderPrice']);

    }

    // 构建微信支付订单信息
    private function makeWxPreOrder($totalPrice)
    {
        $openid = TokenLogic::getCurrentTokenVar('openid');

        if (!$openid) {
            throw new TokenException();
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNo);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice * 100);
        $wxOrderData->SetBody('零食商贩');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url(config('secure.pay_back_url'));
        $config = new \WxPayConfig();
        return $this->getPaySignature($config,$wxOrderData);
    }

    //向微信请求订单号并生成签名
    private function getPaySignature($config,$wxOrderData)
    {
        $wxOrder = \WxPayApi::unifiedOrder($config,$wxOrderData);
        // 失败时不会返回result_code
        if($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] !='SUCCESS'){
            Log::record($wxOrder,'error');
            Log::record('获取预支付订单失败','error');
            throw new Exception('获取预支付订单失败');
        }
        $this->recordPreOrder($wxOrder);
        $signature = $this->sign($wxOrder);
        return $signature;
    }

    // 更新预支付信息
    private function recordPreOrder($wxOrder){
        // 必须是update，每次用户取消支付后再次对同一订单支付，prepay_id是不同的
        OrderModel::where('id', '=', $this->orderID)
            ->update(['prepay_id' => $wxOrder['prepay_id']]);
    }

    // 签名
    private function sign($wxOrder)
    {
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wechat.app_id'));
        $jsApiPayData->SetTimeStamp((string)time()); // 注意 这里需要转换类型
        $rand = md5(time() . mt_rand(0, 1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id=' . $wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');
        $sign = $jsApiPayData->MakeSign();
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;
        unset($rawValues['appId']);
        return $rawValues;
    }

    /*
     * 检测订单操作是否匹配
     */
    public function checkOrderValid()
    {
        // 订单号可能根本不存在
        $order = OrderModel::where('id', '=', $this->orderID)
            ->find();
        if (!$order) {
            throw new OrderException();
        }

        // 订单号存在 但是订单号与当前用户不匹配

//        $currentUid = Token::getCurrentUid();
        if (!TokenLogic::isValidateOperate($order->user_id)) {
            throw new TokenException(
                [
                    'msg' => '订单与用户不匹配',
                    'errorCode' => 10003
                ]);
        }

        // 订单有可能已经被支付
        if ($order->status != OrderStatusEnum::UNPAID) {
            throw new OrderException([
                'msg' => '订单已支付过啦',
                'errorCode' => 80003,
                'code' => 400
            ]);
        }
        $this->orderNo = $order->order_no;
        return true;
    }

}