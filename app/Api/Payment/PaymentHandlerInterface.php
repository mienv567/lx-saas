<?php
namespace App\Api\Payment;

use Illuminate\Http\Request;

/**
 * 支付业务操作接口类
 */
interface PaymentHandlerInterface
{

    /**
     * 生成该支付类型充值显示界面的HTML代码
     * @param $logoPath logo路径
     * @return 显示界面的HTML代码
     */
    public function makeDisplayCode($logoPath);

    /**
     * 生成提交到支付平台的表单代码
     * @param  App/Models/Payment $payment   支付单数据
     * @param  string $subject   订单号，如果为余额充值，subject会为余额充值
     * @return string            表单代码
     */
    public function makePaymentCode($payment, $subject);

    /**
     * 处理支付平台支付成功后跳转回来的请求
     * @param Request $request HTTP请求对象
     * @return 跳转页面代码
     */
    public function handleReturn($request);

    /**
     * 处理支付平台支付成功后后台通知请求
     * @param Request $request HTTP请求对象
     * @return 处理结果信息
     */
    public function handleNotify($request);

}
