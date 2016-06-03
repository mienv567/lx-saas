<?php

namespace App\Http\Controllers\CloudSystem;

use App\Http\Controllers\CloudBase\AppsysMyController;

/**
 * 云系统中我的应用模块操作控制器类
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
        $this->bladePrefix = 'cloud_system.';
        $this->limitDeployPosition = 2;
        $this->productType = 1;
    }

}
