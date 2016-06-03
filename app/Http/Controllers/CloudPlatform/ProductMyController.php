<?php

namespace App\Http\Controllers\CloudPlatform;

use App\Http\Controllers\CloudBase\AppsysMyController;

/**
 * 云平台中我的应用模块操作控制器类
 */
class ProductMyController extends AppsysMyController
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
