<?php

namespace App\Http\Controllers\CloudBase;

use DB;
use Log;
use Redirect;
use App\Models\UserProductForAppsys;
use App\Models\AppsysLicense;
use App\Api\Product\utils\AppsysProductUtil;
use App\Saas\LicenseManager;
use Illuminate\Http\Request;

/**
 * 云应用系统中我的应用模块操作控制器类
 */
class AppsysMyController extends AppsysBaseController
{
    
    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 显示我的应用首页，即展示当前用户已购买的应用产品列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 查询用户名下已购应用
        $user = $request->user();
        $userProducts = UserProductForAppsys::where('user_id', $user->id)->where('product_type', $this->productType)->with('product')->get();
        // 返回结果
        return view($this->bladePrefix.'my_index', ['userProducts' => $userProducts]);
    }

    /**
     * 显示我的应用产品详情页面，可进行设置
     *
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        // 获取我的产品信息
        $id = intval($request->input('id'));
        $userProduct = UserProductForAppsys::find($id);
        if ($userProduct->product_type != $this->productType) {
            $userProduct = null;
        }
        // 判断获取到的产品是否属于当前用户，若不属于，则置空
        if (!empty($userProduct)) {
            $user = $request->user();
            if ($userProduct->user_id != $user->id) {
                $userProduct = null;
            }
        }
        // 获取授权文件信息
        if (!empty($userProduct)) {
            $licenses = AppsysLicense::where('user_id', $userProduct->user_id)->where('appsys_id', $userProduct->product_id)->get();
            if (count($licenses) > 0) {
                $userProduct->license = $licenses[0];
            }
        }
        // 对于云平台，授权文件未生成时，自动生成
        if ($this->productType == 2) { // 云平台
            if (!isset($userProduct->license) || empty($userProduct->license)) {
                $domains = array(); // 授权域名由系统自动生成
                $coreConfigInfo = array(); // 核心配置信息由系统自动生成
                $deployInSaas = true;
                $ret = AppsysProductUtil::createUserProductLicense($userProduct, $domains, $coreConfigInfo, $deployInSaas);
            }
        }
        
        // 返回结果
        return view($this->bladePrefix.'my_detail', ['userProduct' => $userProduct]);
    }

    /**
     * 保存我的应用产品设置
     *
     * @return \Illuminate\Http\Response
     */
    public function productSet(Request $request)
    {
        // 获取当前用户信息
        $user = $request->user();
        // 获取请求参数并解析和验证
        $data = $request->input('data');
        if (empty($data)) {
            return parent::responseJson(1002, '参数不能为空');
        }
        $configInfo = json_decode($data);
        if (empty($configInfo)) {
            return parent::responseJson(1002, '参数格式错误');
        }
        $id = isset($configInfo->id) ? intval($configInfo->id) : null;
        if (empty($id) || $id <= 0) {
            return parent::responseJson(1002, '要设置的产品ID缺失');
        }
        $domains = isset($configInfo->domains) ? $configInfo->domains : null;
        if ($this->productType != 2) { // 云系统
            if (empty($domains) || count($domains) <= 0) {
                return parent::responseJson(1002, '授权域名不能为空');
            }
        }
        $coreConfigs = isset($configInfo->coreConfigs) ? $configInfo->coreConfigs : null;
        // 获取已购产品信息
        $userProduct = UserProductForAppsys::find($id);
        if ($userProduct->product_type != $this->productType) {
            $userProduct = null;
        }
        if (empty($userProduct)) {
            return parent::responseJson(1002, '要设置的产品不存在');
        }
        if ($userProduct->user_id != $user->id) {
            return parent::responseJson(1002, '要设置的产品不属于当前用户');
        }
        // 修正授权域名信息，已有域名保留（不允许被删），再加新的域名
        $fixedDomains = array();
        $settingInfo = empty($userProduct->setting_info) ? null : json_decode($userProduct->setting_info);
        if (!empty($settingInfo) && !empty($settingInfo->licenseInfo) && !empty($settingInfo->licenseInfo->domains)) {
            foreach ($settingInfo->licenseInfo->domains as $domain) {
                $fixedDomains[] = $domain;
            }
        }
        if (!empty($domains)) {
            foreach ($domains as $domain) {
                if (!in_array($domain, $fixedDomains)) {
                    $fixedDomains[] = $domain;
                }
            }
        }
        $domains = $fixedDomains;
        // 设置云平台授权域名
        if ($this->productType == 2) { // 云平台
            $domains = array(); // 授权域名设置为空，manager->createLicense()时默认会创建一个属于当前用户的域名
        }
        // 生成授权文件并更新授权信息到用户产品表中
        $coreConfigInfo = (array)$coreConfigs;
        $deployInSaas = ($this->productType == 2) ? true : false;
        $ret = AppsysProductUtil::createUserProductLicense($userProduct, $domains, $coreConfigInfo, $deployInSaas);
        // 返回结果
        return parent::responseJson($ret['errcode'], $ret['errmsg'], isset($ret['data']) ? $ret['data'] : null);
    }

    /**
     * 下载授权文件
     *
     * @return \Illuminate\Http\Response
     */
    public function downLicense(Request $request)
    {
        // 获取当前用户信息
        $user = $request->user();
        // 获取授权信息
        $id = intval($request->input('id'));
        $data = AppsysLicense::find($id);
        if (empty($data) || $data->user_id != $user->id) {
            return '授权信息不存在';
        }
        // 将授权信息保存到临时文件中
        $tempfile = tempnam(sys_get_temp_dir(), 'fwl');
        file_put_contents($tempfile, $data->license_info);
        // 返回下载文件洗洗脑
        return response()->download($tempfile, 'license')->deleteFileAfterSend(true);
    }
    
}
