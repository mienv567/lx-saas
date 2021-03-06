<?php
namespace App\Api\Product;

use App\Models\Appsys;
use App\Models\AppsysSaleItem;
use App\Models\Order;
use App\Models\UserProduct;
use App\Api\Product\utils\AppsysProductUtil;
use DBLog;
use Log;

class AppsysProductHandler extends AbstractProductHandler
{

    /**
     * 生成应用系统产品订单
     * @param $userId 购买用户ID
     * @param $orderTopic 订单标题
     * @param $productType 购买产品类型：0-云服务；1-云系统；2-云平台
     * @param $productId 购买产品ID
     * @param $saleItemId 产品销售套餐ID
     * @param $orderMoney 订单金额（单位：元）
     * @param $buyInfo 购买的产品信息（PHP数组）
     * @return 生成的订单信息
     */
    public function makeOrder($userId, $orderTopic, $productType, $productId, $saleItemId, $orderMoney, array $buyInfo)
    {
        return parent::makeCommonOrder($userId, $orderTopic, $productType, $productId, $saleItemId, $orderMoney, $buyInfo);
    }

    /**
     * 生成订单中的产品，如生将订单中的产品入库到用户产品库中并进行相应设置、增加订单中购买的短信条数等
     * @param $orderId 订单ID
     * @return 生成结果，成功返回true，失败返回false
     */
    public function makeOrderProduct($orderId)
    {
        try {
            // 获取订单信息
            $order = Order::find($orderId);
            if (empty(($order))) {
                return false;
            }
            // 获取订单关联产品名称
            $productName = null;
            $appsys = Appsys::find($order->product_id);
            if (!empty($appsys)) {
                $productName = $appsys->name;
            }
            // 获取订单关联产品销售套餐名称
            $saleItemName = null;
            $saleItem = AppsysSaleItem::find($order->sale_item_id);
            if (!empty($saleItem)) {
                $saleItemName = $saleItem->name;
            }
            // 生成我的产品信息，如果该订单产品已生成，那么覆盖已生成的数据
            // $userProducts = UserProduct::where('order_id', $orderId)->get();
            $userProducts = UserProduct::where('user_id', $order->user_id)->where('product_type', $order->product_type)->where('product_id', $order->product_id)->get();
            $userProduct = (!empty($userProducts) && count($userProducts) > 0) ? $userProducts[0] : null;
            if (empty($userProduct)) {
                $userProduct = new UserProduct;
            }
            $userProduct->user_id = $order->user_id;
            $userProduct->product_type = $order->product_type;
            $userProduct->product_id = $order->product_id;
            $userProduct->product_name = $productName;
            $userProduct->sale_item_id = $order->sale_item_id;
            $userProduct->sale_item_name = $saleItemName;
            $userProduct->order_id = $order->id;
            $userProduct->buy_info = $order->buy_info;
            $userProduct->setting_info = null;
            // 入库我的产品信息，如果是云平台产品，那么自动生成授权文件
            if ($userProduct->product_type == 2) { // 云平台产品，授权文件自动生成
                $domains = array(); // 授权域名由系统自动生成
                $coreConfigInfo = array(); // 核心配置信息由系统自动生成
                $deployInSaas = true;
                $ret = AppsysProductUtil::createUserProductLicense($userProduct, $domains, $coreConfigInfo, $deployInSaas); // 将自动保存我的产品信息到数据库
                if ($ret['errcode'] != 0) {
                    $message = sprintf("Call createUserProductLicense() fail, errcode: %s, errmsg: %s, order_id: %s.", $ret['errcode'], $ret['errmsg'], $userProduct->order_id);
                    Log::error($message);
                    DBLog::error($message);
                    return false;
                }
            } else { // 云系统产品，先保存用户产品信息，授权文件由用户配置后生成
                $userProduct->save();
            }
            // 返回结果
            return true;
        } catch (\Exception $e) {
            $message = 'Call makeOrderProduct($orderId) error, $orderId=' . $orderId . ', error message: ' . $e->getMessage();
            Log::error($message);
            DBLog::error($message);
            return false;
        }
    }

    /**
     * 根据订单表中的购买信息生成显示给用户看的购买详情界面信息（HTML代码）
     * @param $buyInfo 订单表中保存的购买信息（JSON格式字符串）
     */
    public function displayBuyInfo($buyInfo)
    {
        //设置默认变量
        $licenseFuncPackage = '';
        $licenseDomainCount = '';
        $licenseMonthCount = '';

        $buyInfo = json_decode($buyInfo, true);
        if (array_key_exists('license_func_package', $buyInfo)) {
            $licenseFuncPackage = $buyInfo['license_func_package'];
        }
        if (array_key_exists('license_domain_count', $buyInfo)) {
            $licenseDomainCount = $buyInfo['license_domain_count'];
            if ($licenseDomainCount == 0) {
                $licenseDomainCount = '无限';
            } else {
                $licenseDomainCount = $licenseDomainCount . '个';
            }
        }
        if (array_key_exists('license_day_count', $buyInfo)) {
            $licenseMonthCount = $buyInfo['license_day_count'];
            if ($licenseMonthCount == 0) {
                $licenseMonthCount = '无限';
            } else {
                $licenseMonthCount = $licenseMonthCount . '天';
            }
        }
        return '<div class="purchasedetails">
                    <table class="table tbgydetail">
                        <thead>
                            <tr>
                              <th colspan="2">购买详情</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <td class="tit">功能套餐号：</td>
                              <td>' . $licenseFuncPackage . '</td>
                            </tr>
                            <tr>
                              <td class="tit">授权域名数：</td>
                              <td>' . $licenseDomainCount . '</td>
                            </tr>
                            <tr>
                              <td class="tit">授权期限：</td>
                              <td>' . $licenseMonthCount . '</td>
                            </tr>
                        </tbody>
                    </table>
                </div>';
    }
    
}
