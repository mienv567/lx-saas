<?php
namespace App\Api\Product;

use Illuminate\Http\Request;

/**
 * 产品业务处理接口类
 */
interface ProductHandlerInterface
{

    /**
     * 生成购买产品时显示的界面信息（HTML代码）
     * @param $productId 购买的产品ID
     */
    //public function makeDisplayBuyCode($productId);

    /**
     * 根据用户选择的购买信息生成保存到订单表中的购买信息（JSON格式字符串）
     * @param Request $request
     */
    //public function makeBuyInfo(Request $request);

    /**
     * 生成订单标题
     * @param $productId 产品ID
     * @param $buyInfo 购买的信息（JSON格式字符串，如：数量、有效期、套餐号等）
     */
    //public function makeOrderTopic($productId, $buyInfo);
    
    /**
     * 生成订单中的产品，如生将订单中的产品入库到用户产品库中并进行相应设置、增加订单中购买的短信条数等
     * @param $orderId 订单ID
     * @return 生成结果，成功返回true，失败返回false
     */
    public function makeOrderProduct($orderId);

    /**
     * 根据订单表中的购买信息生成显示给用户看的购买详情界面信息（HTML代码）
     * @param $buyInfo 订单表中保存的购买信息（JSON格式字符串）
     */
    public function displayBuyInfo($buyInfo);

    /**
     * 根据传入的域名生成应用服务访问地址
     * @param $user 登录用户信息
     * @param $domain 域名信息
     */
    public function makeServiceUrl($user, $domain);
    
}
