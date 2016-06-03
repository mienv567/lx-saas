<?php
namespace App\Api\Payment;

use App\Http\Controllers\User\FinanceManageController;
use App\Models\Payment as PaymentModel;
use App\Models\PaymentType;
use Illuminate\Http\Request;

/**
 * 产品业务处理接口类
 */
class AlipayPaymentHandler implements PaymentHandlerInterface
{

    /**
     * 生成该支付类型充值显示界面的HTML代码
     * @return 显示界面的HTML代码
     */
    public function makeDisplayCode($logoPath)
    {
        if (is_null($logoPath)) {
            $logoPath = '../res/images/zfb.png';
        }
        return '<div class="rechargebox active">
              <img alt="" src="' . $logoPath . '">
            </div>';
    }

    /**
     * 生成提交到支付平台的表单代码
     * @param  App/Models/Payment $payment   支付单数据
     * @param  string $subject   订单号，如果为余额充值，subject会为余额充值
     * @return string            表单代码
     */
    public function makePaymentCode($payment, $subject)
    {
        $paymentType = $payment->paymentType;
        $paymentTypeConfig = unserialize($paymentType->config);

        $returnUrl = url('api/financial_recharge_response') . '?class_name=Alipay';
        $notifyUrl = url('api/financial_recharge_notify') . '?class_name=Alipay';

        $parameter = array(
            'service' => 'create_direct_pay_by_user',
            'partner' => $paymentTypeConfig['partner'],
            //'partner'           => ALIPAY_ID,
            '_input_charset' => 'utf-8',
            'notify_url' => $notifyUrl,
            'return_url' => $returnUrl,
            /* 业务参数 */
            'subject' => $subject,
            'out_trade_no' => $payment->payment_no,
            'price' => $payment->prepay_money,
            'quantity' => 1,
            'payment_type' => 1,
            /* 物流参数 */
            'logistics_type' => 'EXPRESS',
            'logistics_fee' => 0,
            'logistics_payment' => 'BUYER_PAY_AFTER_RECEIVE',
            /* 买卖双方信息 */
            'seller_email' => $paymentTypeConfig['seller_email'],
        );

        ksort($parameter);
        reset($parameter);

        $param = '';
        $sign = '';

        foreach ($parameter as $key => $val) {
            $param .= "$key=" . urlencode($val) . "&";
            $sign .= "$key=$val&";
        }
        $param = substr($param, 0, -1);
        $sign = substr($sign, 0, -1) . $paymentTypeConfig['alipay_key'];
        $sign_md5 = md5($sign);
        $payLinks = '<form id="_PayForm" action="https://mapi.alipay.com/gateway.do?' . $param . '&sign=' . $sign_md5 . '&sign_type=MD5" method="POST" target="" ><button type="submit" class="ui-button paybutton" rel="blue">前往支付宝在线支付</button></form>';

        return $payLinks;
    }

    /**
     * 处理支付平台支付成功后跳转回来的请求
     * @param $request string HTTP请求对象
     * @return 跳转页面代码
     */
    public function handleReturn($request)
    {
        $returnRes = array(
            'payment' => '',
            'status' => false,
            'money' => '',
        );
        $paymentType = PaymentType::where('class_name', $request['class_name'])->first();
        $paymentType['config'] = unserialize($paymentType['config']);
        /* 检查数字签名是否正确 */
        ksort($request);
        reset($request);

        $sign = '';
        foreach ($request as $key => $val) {
            if ($key != 'sign' && $key != 'sign_type' && $key != 'code' && $key != 'class_name' && $key != 'act' && $key != 'ctl' && $key != 'city' && $key != '_token') {
                $sign .= "$key=$val&";
            }
        }

        $sign = substr($sign, 0, -1) . $paymentType['config']['alipay_key'];

        if (md5($sign) != $request['sign']) {

            return $returnRes;
        }

        $payment_no = $request['out_trade_no'];

        $money = $request['total_fee'];

        $out_trade_no = $request['trade_no'];

        if ($request['trade_status'] == 'TRADE_SUCCESS' || $request['trade_status'] == 'TRADE_FINISHED' || $request['trade_status'] == 'WAIT_SELLER_SEND_GOODS' || $request['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS') {
            $payment = PaymentModel::where('payment_no', $payment_no)->first();
            if ($payment->order_id == 0) {
                //充值成功后,更新支付表中的交易流水号以及时间
                $returnStatus = PaymentModel::tradeResponse($request);
                $returnRes = array(
                    'payment' => $payment_no,
                    'status' => $returnStatus['status'],
                    'money' => $returnStatus['money'],
                );

                return $returnRes;
            } else {
                // 订单支付成功后,更新订单数据
                $returnStatus = FinanceManageController::orderTradeResponse($request);
                $returnRes = array(
                    'payment' => $payment_no,
                    'status' => $returnStatus['status'],
                    'money' => $returnStatus['money'],
                );
                return $returnRes;
            }

        } else {

            return $returnRes;
        }

    }

    /**
     * 处理支付平台支付成功后后台通知请求
     * @param $request string HTTP请求对象
     * @return 处理结果信息
     */
    public function handleNotify($request)
    {
        $paymentType = PaymentType::where('class_name', $request['class_name'])->first();
        $paymentType['config'] = unserialize($paymentType['config']);
        /* 检查数字签名是否正确 */
        ksort($request);
        reset($request);

        $sign = '';
        foreach ($request as $key => $val) {
            if ($key != 'sign' && $key != 'sign_type' && $key != 'code' && $key != 'class_name' && $key != 'act' && $key != 'ctl' && $key != 'city' && $key != '_token') {
                $sign .= "$key=$val&";
            }
        }

        $sign = substr($sign, 0, -1) . $paymentType['config']['alipay_key'];

        if (md5($sign) != $request['sign']) {

            return false;
        }

        $payment_no = $request['out_trade_no'];

        $money = $request['total_fee'];

        $out_trade_no = $request['trade_no'];

        if ($request['trade_status'] == 'TRADE_SUCCESS' || $request['trade_status'] == 'TRADE_FINISHED' || $request['trade_status'] == 'WAIT_SELLER_SEND_GOODS' || $request['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS') {
            $payment = PaymentModel::where('payment_no', $payment_no)->first();
            if ($payment->order_id == 0) {
                //更新支付表中的交易流水号以及时间
                $notify = PaymentModel::tradeResponse($request);

            } else {
                // 订单支付成功后,更新订单数据
                $returnStatus = FinanceManageController::orderTradeResponse($request);
            }

            return true;

        } else {

            return false;
        }
    }

}
