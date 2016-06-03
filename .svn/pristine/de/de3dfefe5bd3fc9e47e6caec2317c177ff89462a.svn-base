<?php
namespace App\Api\Product;

use App\Models\Order;
use App\Models\User;
use Log;
use DBLog;
use Auth;

/**
 * 流量红包产品处理类
 */
class FlowGiftProductHandler extends AbstractProductHandler
{

    /**
     * 生成流量红包产品订单
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
        if($order){
            if($order['order_status']==1){
                $buyinfo = json_decode($order['buy_info'],true);
                $user = User::find($order->user_id);
                if(empty($user)){
                    $message = 'Create FlowGift user error, $orderId='.$order->id.', error message:订单用户不存在 ';
                    Log::error($message);
                    DBLog::error($message);
                    return false;
                }
                $smsinfo['act'] ='query';
                $smsinfo['appid'] = $user->app_id;
                $smsinfo['appsecret'] = $user->app_password;
                $smsinfo = json_encode($smsinfo);
                $curlPost = 'server_string='.$smsinfo;
                $url = 'http://www.niuhudong.cn/userpost.php';
                $ch = curl_init();
                curl_setopt ( $ch, CURLOPT_URL, $url );
                curl_setopt ($ch,  CURLOPT_RETURNTRANSFER,1);
                curl_setopt ( $ch, CURLOPT_POST, 1 ); //启用POST提交
                curl_setopt ($ch,CURLOPT_POSTFIELDS,$curlPost);
                $result = curl_exec ($ch);
                curl_close($ch);
                $result = json_decode($result,true);
                if($result["status"]==1){
                    $smsinfo=array();
                    $smsinfo['act'] ='modifyuser';
                    $smsinfo['appid'] = $user['app_id'];
                    $smsinfo['appsecret'] = $user['app_password'];
                    $smsinfo['money'] = ($buyinfo['flowMoney']+$result['data']['money']);
                    $smsinfo = json_encode($smsinfo);
                    $curlPost = 'server_string='.$smsinfo;
                    $url = 'http://www.niuhudong.cn/userpost.php';
                    $ch = curl_init();
                    curl_setopt ( $ch, CURLOPT_URL, $url );
                    curl_setopt ($ch,  CURLOPT_RETURNTRANSFER,1);
                    curl_setopt ( $ch, CURLOPT_POST, 1 ); //启用POST提交
                    curl_setopt ($ch,CURLOPT_POSTFIELDS,$curlPost);
                    $result = curl_exec ($ch);
                    curl_close($ch);
                    $result = json_decode($result,true);
                    if($result['status']==1){
                        return true;
                    }else{
                        $message = 'Create FlowGift user error, $orderId='.$order->id.', error message:牛互动金额修改失败 ';
                        Log::error($message);
                        DBLog::error($message);
                    }
                }else{
                    $message = 'Create FlowGift user error, $orderId='.$order->id.', error message:牛互动用户不存在 ';
                    Log::error($message);
                    DBLog::error($message);
                }
            }else{
                $message = 'Create FlowGift user error, $orderId='.$order->id.', error message: 订单未支付成功 ';
                Log::error($message);
                DBLog::error($message);
            }
        }else{
            $message = 'Create FlowGift user error, $orderId='.$orderId.', error message: '.$orderId."订单不存在";
            Log::error($message);
            DBLog::error($message);
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