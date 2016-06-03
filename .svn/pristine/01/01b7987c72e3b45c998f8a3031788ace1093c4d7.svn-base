<?php
namespace App\Api\Product;

use App\Models\Appsys;
use App\Models\Order;
use App\Models\User;
use Log;
use DBLog;
use Auth;

/**
 * 流量红包应用产品处理类
 */
class FlowGiftAppProductHandler extends AppsysProductHandler
{

    /**
     * 生成订单中的产品，如生将订单中的产品入库到用户产品库中并进行相应设置、增加订单中购买的短信条数等
     * @param $orderId 订单ID
     * @return 生成结果，成功返回true，失败返回false
     */
    public function makeOrderProduct($orderId)
    {
        // 将产品入库到用户产品库中
        $ret = parent::makeOrderProduct($orderId);
        if (!$ret) {
            return false;
        }
        // 生成流量红包系统用户
        try {
            $order = Order::find($orderId);
            if($order){
                $user = User::find($order->user_id);
                if(empty($user)){
                    $message = 'Create FlowGift user error, $orderId='.$order->id.', error message:订单用户不存在 ';
                    Log::error($message);
                    DBLog::error($message);
                    return false;
                }
                // 创建流量红包用户
                //判断用户是否已存在
                $smsinfo = array();
                $smsinfo['act'] ='query';
                $smsinfo['appid'] = $user['app_id'];
                $smsinfo['appsecret'] = $user['app_password'];
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
                if(isset($result['data']['user_name']) && $result['data']['user_name']==$user['app_id']){
                    //已经存在，返回成功
                    return true;
                }else{
                    $send_flow_money = 0;//赠送购买用户流量金额
                    $buy_info = json_decode($order->buy_info,true);
                    if(!empty($buy_info['license_extra_info'])){
                        $license_extra_info = json_decode($buy_info['license_extra_info'],true);
                        if(isset($license_extra_info['send_flow_money']) && $license_extra_info['send_flow_money']!=null && $license_extra_info['send_flow_money']>0){
                            $send_flow_money = $license_extra_info['send_flow_money'];
                        }
                    }

                    //不存在，创建用户
                    $smsinfo = array();
                    $smsinfo['act'] ='adduser';
                    $smsinfo['appid'] = $user['app_id'];
                    $smsinfo['appsecret'] = $user['app_password'];
                    if($send_flow_money>0){
                        $smsinfo['money'] = $send_flow_money;
                    }
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
                        $appsys = Appsys::find($order->product_id);
                        if($appsys->main_domain){
                            $http = '';
                            if(strstr($appsys->main_domain,'http://')==''){
                                $http = 'http://';
                            }
                            $main_domain = $http.$user['id'].'.'.$appsys->main_domain.'/install/index.php?m=Index&a=install';
                            file_get_contents($main_domain);
                        }
                        return true;
                    }else{
                        $message = 'Create FlowGift user error, $orderId='.$orderId.', error message: '.$result['msg']." appid:".$user['app_id'].'  appsecret:'.$user['app_password'];
                        Log::error($message);
                        DBLog::error($message);
                    }
                }
            }else{
                $message = 'Create FlowGift user error, $orderId='.$orderId.', error message: '.$orderId."订单不存在";
                Log::error($message);
                DBLog::error($message);
            }

            // 返回结果
            return false;
        } catch (\Exception $e) {
            $message = 'Create FlowGift user error, $orderId='.$orderId.', error message: '.$e->getMessage();
            Log::error($message);
            DBLog::error($message);
            return false;
        }
    }

    /**
     * 默认根据传入的域名生成应用服务访问地址
     * @param $user 登录用户信息
     * @param $domain 域名信息
     */
    public function makeServiceUrl($user, $domain)
    {
        $client = new \SAASAPIClient();
        $baseUrl = 'http://'.$domain.'/settings.html';
        $widthAppid = true;  // 生成的安全地址是否附带appid参数
        $timeoutMinutes = 10; // 安全参数过期时间（单位：分钟），小于等于0表示永不过期
        $params = array('userid' => $user->id, 'username' => $user->username);
        return $client->makeSecurityUrl($baseUrl, $params, $widthAppid, $timeoutMinutes);
    }
    
}

?>