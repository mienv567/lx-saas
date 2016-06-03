<?php

namespace App\Http\Controllers\Api;

use App\Api\Product\utils\ProductUtil;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

/**
 * 支付端口访问api控制器类
 */
class SaasApiController extends Controller
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
     * 订单处理失败后调用该接口重新处理
     * @param  Request $request HTTP请求对象
     * @return json  $result 订单生成结果
     */
    public function errorOrderHandle(Request $request)
    {
        // 初始化操作
        $server = new \SAASAPIServer();
        // 验证客户端请求参数（时间戳、参数验证等）
        $ret = $server->verifyRequestParameters($request->all());
        if ($ret['errcode'] != 0) {
            return $server->toResponse($ret);
        }

        $orderNo = $request->order_no;
        $order = Order::where('order_no', $orderNo)->first();
        if (empty($order)) {
            return parent::responseJson(1002, '订单输入有误，无此订单');
        }
        //异常订单，生成产品处理
        $productUtil = new ProductUtil;
        $result = $productUtil->dealErrorOrder($order);
        return $result;

    }

}
