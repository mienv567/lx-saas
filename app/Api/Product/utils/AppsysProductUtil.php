<?php
namespace App\Api\Product\utils;

use App\Saas\LicenseManager;
use App\Models\UserProduct;

/**
 * 应用产品相关操作工具栏
 */
class AppsysProductUtil
{

    /**
     * 生成用户已购产品授权文件，生成授权文件同时，会更新或保存用户已购商品信息表内容
     * @param $userProduct 用户已购产品信息
     * @param $domains 授权域名列表
     * @param $coreConfigInfo 授权核心配置信息
     * @param $deployInSaas 授权产品是否为部署在云平台的产品
     * @return 生成结果，数组对象，如：array("errcode"=>0,"errmsg"=>"")
     */
    public static function createUserProductLicense(UserProduct $userProduct, array $domains, array $coreConfigInfo, $deployInSaas)
    {
        // 设置授权信息
        $buyInfo = json_decode($userProduct->buy_info);
        if (empty($buyInfo)) {
            $message = 'createCloudPlatformLicense fail, buy_info is empty, order_id: '.$userProduct->order_id;
            return ['errcode' => 1002, 'errmsg' => '要生成授权的产品购买信息无效'];
        }
        $licenseFuncPackage = isset($buyInfo->license_func_package) ? $buyInfo->license_func_package : null;
        $licenseDomainCount = isset($buyInfo->license_domain_count) ? intval($buyInfo->license_domain_count) : 0;
        $licenseDayCount = isset($buyInfo->license_day_count) ? intval($buyInfo->license_day_count) : 0;
        if ($licenseDayCount > 0) {
            $startTime = empty($userProduct->created_at) ? time() : strtotime($userProduct->created_at);
            $licenseExpireTime = date('Y-m-d H:i:s', strtotime('+'.$licenseDayCount.' day', $startTime));
        } else {
            $licenseExpireTime = null;
        }
        if ($licenseDomainCount > 0 && count($domains) > $licenseDomainCount) {
            return ['errcode' => 1002, 'errmsg' => '设置的域名数超过授权域名数'];
        }
        $licenseInfo = array('domains'=>$domains, 'func_package'=>$licenseFuncPackage, 'expire_time'=>$licenseExpireTime);
        // 生成产品授权
        $manager = new LicenseManager;
        $ret = $manager->createLicense($userProduct->user_id, $userProduct->product_id, $licenseInfo, $coreConfigInfo, $deployInSaas, true);
        if ($ret['errcode'] == 2005) {
            return ['errcode' => 1002, 'errmsg' => '所添加的域名已被授权'];
        } else if ($ret['errcode'] != 0) {
            return ['errcode' => 1002, 'errmsg' => '授权文件生成失败：'.$ret['errmsg']];
        }
        // 保存产品设置
        $userProduct->setting_info = json_encode(array('licenseInfo'=>$licenseInfo, 'coreConfigInfo'=>$coreConfigInfo));
        $userProduct->save();
        // 返回结果
        return $ret; // 直接返回$manager->createLicense()方法的返回结果（成功结果）
    }
    
}

?>