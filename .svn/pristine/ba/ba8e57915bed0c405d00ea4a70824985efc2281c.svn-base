<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

/**
 * 支付端口访问api控制器类
 */
class PayApiController extends Controller
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
     * 支付成功响应
     * @param  Request $request HTTP请求对象
     * @return \Illuminate\Http\Response
     */
    public function response(Request $request)
    {
        $className = 'App\Api\Payment\\' . ucfirst($request->class_name) . 'PaymentHandler';
        $paymentHander = new $className();

        $returnRes = $paymentHander->handleReturn($request->all());
        $payment = Payment::where('payment_no', $returnRes['payment'])->first();
        $user = $payment->user;
        if ($returnRes['status']) {
            if ($payment->order_id == 0) {
                return view('user.financial_recharge_response', ['payment' => $payment]);
            } else {
                $order = Order::find($payment->order_id);
                return view('user.financial_pay_success', [
                    'user' => $user,
                    'order' => $order,
                ]);
            }

        } elseif (!is_null($payment)) {
            if ($payment->order_id == 0) {
                return view('user.financial_recharge_response_fail', [
                    'payment' => $payment,
                    'money' => $returnRes['money'],
                ]);
            }
        } else {
            return 'fail';
        }

    }

    /**
     * 支付成功通知
     * @param  Request $request HTTP请求对象
     * @return string           是否成功
     */
    public function notify(Request $request)
    {
        $className = 'App\Api\Payment\\' . ucfirst($request->class_name) . 'PaymentHandler';
        $paymentHander = new $className();
        $paymentRsponse = $paymentHander->handleNotify($request->all());
    }
}
