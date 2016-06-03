<?php

namespace App\Http\Controllers\CloudSystem;

use App\Http\Controllers\CloudBase\AppsysMarketController;

/**
 * 云系统中应用市场模块操作控制器类
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
        $this->bladePrefix = 'cloud_system.';
        $this->limitDeployPosition = 2;
        $this->productType = 1;
    }

}
