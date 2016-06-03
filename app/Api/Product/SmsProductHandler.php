<?php
namespace App\Api\Product;

use App\Models\Order;
use App\Models\User;
use App\Services\CommonUtils;
use Log;
use DBLog;

/**
 * 短信充值产品处理类
 */
class SmsProductHandler extends AbstractProductHandler
{

    /**
     * 生成短信充值产品订单
     * @param $userId 购买用户ID
     * @param $orderTopic 订单标题
     * @param $productId 购买产品ID
     * @param $orderMoney 订单金额（单位：元）
     * @param $buyInfo 购买的产品信息（PHP数组）
     */
    public function makeOrder($userId, $orderTopic, $productId, $orderMoney, array $buyInfo)
    {
        $productType = 0; // 购买产品类型：0-云服务；1-云系统；2-云平台
        $saleItemId = 0;
        return parent::makeCommonOrder($userId, $orderTopic, $productType, $productId, $saleItemId, $orderMoney, $buyInfo);
    }

    /**
     * 生成订单中的产品，如生将订单中的产品入库到用户产品库中并进行相应设置、增加订单中购买的短信条数等
     * @param $orderId 订单ID
     * @return 生成结果，成功返回true，失败返回false
     */
    public function makeOrderProduct($orderId)
    {
        $order = Order::find($orderId);
        if(empty($order)){
            $message = 'Create Sms user error, $orderId='.$orderId.', error message: '.$orderId."订单不存在";
            Log::error($message);
            DBLog::error($message);
            return false;
        }
        if($order['order_status']==1) {
            $commonUtil = new CommonUtils();
            $buyinfo = json_decode($order['buy_info'], true);
            if (!isset($buyinfo['smsNumber']) || $buyinfo['smsNumber'] <= 0) {
                $message = 'Create Sms user error, $orderId=' . $orderId . ',smsNumber = ' . $buyinfo['smsNumber'] . ' error message:充值数量有误';
                Log::error($message);
                DBLog::error($message);
                return false;
            }
            $user = User::find($order->user_id);
            if (empty($user)) {
                $message = 'Create Sms user error, $orderId=' . $orderId . ', error message:订单用户不存在 ';
                Log::error($message);
                DBLog::error($message);
                return false;
            }
            $smsinfo = array();
            $smsinfo['act'] = 'updateblance';
            $smsinfo['appid'] = $user->app_id;
            $smsinfo['user_id'] = $buyinfo['smsUserId'];
            $smsinfo['sms_number'] = $buyinfo['smsNumber'];
            ksort($smsinfo);
            $sign_str = "";
            foreach ($smsinfo as $k => $v) {
                $sign_str .= $k . "|" . $v;
            }
            $smsinfo['sign_str'] = md5($sign_str . "KJHKJHKJN<MNMNBU&T*&^*&^*YIHKJHjk");
            $smsinfo = json_encode($smsinfo);
            $url = 'http://sms.fanwe.com/userpost';
            $result = $commonUtil->curlRequest($url, $smsinfo);
            $result = json_decode($result, true);
            if ($result['status'] == 0) {
                $message = 'Create Sms user error, $orderId=' . $orderId . ', error message: 短信平台-' . $result['msg'];
                Log::error($message);
                DBLog::error($message);
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * 根据订单表中的购买信息生成显示给用户看的购买详情界面信息（HTML代码）
     * @param $buyInfo 订单表中保存的购买信息（JSON格式字符串）
     */
    public function displayBuyInfo($buyInfo)
    {
        return "";
    }

}

?>