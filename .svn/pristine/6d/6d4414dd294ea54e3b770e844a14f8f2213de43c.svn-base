<?php
namespace App\Api\Product\utils;

use App\Http\Controllers\Controller;
use App\Models\Appsvc;
use App\Models\Appsys;
use App\Models\Order;
use DBLog;
use Log;

class ProductUtil
{

    /**
     * 处理异常订单
     * @param $order 待处理订单信息
     */
    public function dealErrorOrder($order)
    {
        $controller = new Controller;
        $orderStatus = $order->order_status;
        $orderId = $order->id;
        switch ($orderStatus) {
            //订单未支付完成
            case '0':
                return $controller->responseJson(1002, '订单未支付完成');
                break;
            //订单完成,产品生成成功
            case '2':
                return $controller->responseJson(1002, '订单完成');
                break;
            //订单已取消
            case '4':
                return $controller->responseJson(1002, '订单已取消');
                break;
            //支付完成，产品未生成，继续生成产品，并把结果返回
            default:
                try {
                    if ($order->product_type == 1 || $order->product_type == 2) {
                        $product = Appsys::find($order->product_id);
                        $className = 'App\Api\Product\\' . trim($product->class_name);
                        $appsys = new $className;
                        $makeResult = $appsys->makeOrderProduct($orderId);
                    } elseif ($order->product_type == 0) {
                        $product = Appsvc::find($order->product_id);
                        $className = 'App\Api\Product\\' . trim($product->class_name);
                        $appsys = new $className;
                        $makeResult = $appsys->makeOrderProduct($order->id);
                    }
                    if (!$makeResult) {
                        return $controller->responseJson(1001, '订单生成异常，请重新生成');
                    } else {
                        $order->order_status = 2;
                        $order->save();
                    }
                } catch (\Exception $e) {
                    $message = 'Make order product error, $orderId=' . $orderId . ', error message: ' . $e->getMessage();
                    Log::error($message);
                    DBLog::error($message);
                    return $controller->responseJson(1001, '订单生成异常，请重新生成');
                }
                break;
        }
        // 返回结果
        return $controller->responseJson(0, '订单完成，产品生成成功');
    }

}
