<?php

namespace App\Http\Controllers\CloudPlatform;

use App\Http\Controllers\CloudBase\AppsysMarketController;

/**
 * 云平台中应用市场模块操作控制器类
 */
class ProductMarketController extends AppsysMarketController
{
    
    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->bladePrefix = 'cloud_platform.';
        $this->limitDeployPosition = 1;
        $this->productType = 2;
    }

}
