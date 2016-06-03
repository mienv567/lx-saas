<?php
namespace App\Api\Product;

use App\Models\Order;

abstract class AbstractProductHandler implements ProductHandlerInterface
{

    /**
     * 生成产品订单，适合各种类型产品
     * @param $userId 购买用户ID
     * @param $orderTopic 订单标题
     * @param $productType 购买产品类型：0-云服务；1-云系统；2-云平台
     * @param $productId 购买产品ID
     * @param $saleItemId 产品销售套餐ID
     * @param $orderMoney 订单金额（单位：元）
     * @param $buyInfo 购买的产品信息（PHP数组）
     * @return 生成的订单信息
     */
    public function makeCommonOrder($userId, $orderTopic, $productType, $productId, $saleItemId, $orderMoney, array $buyInfo)
    {
        $order = new Order;
        $order->order_no = $this->makeOrderNo();
        $order->order_topic = $orderTopic;
        $order->user_id = $userId;
        $order->product_type = $productType;
        $order->product_id = $productId;
        $order->sale_item_id = $saleItemId;
        $order->buy_info = json_encode($buyInfo);
        $order->order_money = $orderMoney;
        $order->pay_money = 0;
        $order->order_status = 0;
        $order->save();
        return $order;
    }

    /**
     * 生成一个唯一的订单号
     * @return 生成的订单号
     */
    public function makeOrderNo()
    {
        $time = time() + 8 * 3600;
        $date = date('Ymdhis', $time);
        do {
            $orderNo = $date.sprintf("%04d", rand(0, 9999));
            $data = Order::where('order_no', $orderNo)->get();
        } while ($data->count() > 0);
        return $orderNo;
    }

    /**
     * 默认根据传入的域名生成应用服务访问地址
     * @param $user 登录用户信息
     * @param $domain 域名信息
     */
    public function makeServiceUrl($user, $domain)
    {
        return 'http://'.$domain;
    }
    
}

?>