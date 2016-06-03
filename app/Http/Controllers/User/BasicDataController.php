<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

/**
 * 企业用户基本资料管理控制器类
 */
class BasicDataController extends Controller
{
    
    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * 显示首页
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 获取登录用户信息
        // $user = $request->user();
        $user = User::find(1);
        // 显示页面信息
        return view('user.basic_data', ['user' => $user]);
    }
    
}
