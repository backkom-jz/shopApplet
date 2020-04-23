<?php
/**
 * Created by PhpStorm.
 * User: 凸^-^凸
 * Date:  2020-04-23 11:52
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\OrderPlace;
use app\api\model\Order as OrderModel;
use app\api\logic\Token as TokenLogic;
use app\api\logic\Order as OrderLogic;
use app\lib\exception\OrderException;
use think\Db;

class Order extends BaseController
{
    /*
     * 用户选择商品后，向API提交包含它所含选择商品的相关信息
     * API在接收到信息后，需要检查订单相关商品的库存单
     * 有库存，把订单数据存入数据库中 = 下单成功了，返回客户端消息，告诉客户端可以支付
     * 调用我们的支付接口，进行支付
     * 还要再次进行库存检测
     * 服务器这边就可以调用微信的支付接口进行支付
     * 微信会返回给我们一个支付的接口（异步）
     * 成功，也需要进行库存量的检查
     * 成功，进行库存量的扣除
     */

    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getDetail,getSummaryByUser'],
        'checkSuperScope' => ['only' => 'delivery,getSummary']
    ];

    /*
     * 下单
     * @url /order
     * @HTTP POST
     */
    public function placeOrder()
    {
        (new OrderPlace())->goCheck();
        Db::startTrans();
        try {
            $products = input('post.products/a');
            $uid = TokenLogic::getCurrentUid();

            $order = new OrderLogic();
            $status = $order->place($uid, $products);
            Db::commit();
            return $status;
        } catch (\Exception $e) {
            Db::rollback();
            return $e->getMessage();
        }
    }

    /*
     * 获取订单详情
     * @param $id
     * @url /order/:id
     * @return static
     */
    public function getDetail($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $orderDetail = OrderModel::get($id);
        if (!$orderDetail) {
            throw new OrderException();
        }
        return $orderDetail->hidden(['prepay_id']);
    }

    /*
     * 更新订单
     * @url /order/delivery
     * @HTTP PUT
     */
    public function delivery($id){
        (new IDMustBePositiveInt())->goCheck();
        $order = new OrderLogic();
        $success = $order->delivery($id);
        if($success){
            return new SuccessMessage();
        }
    }

}