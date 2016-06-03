<?php

namespace App\Models;

use App\Models\RechargeLog;
use App\Models\User as UserModel;
use Auth;
use Carbon\Carbon;
use DB;
use DBLog;
use Illuminate\Database\Eloquent\Model;
use Log;

class Payment extends Model
{

    protected $table = 'saas_payment';

    /**
     * 创建支付记录单
     * @param  int $orderId 订单id
     * @param  double $prepayMoney 预付金额
     * @param  int $paymentTypeId 支付类型id
     * @return App\Models\Payment  $payment 订单
     */
    public static function createPaymentByOrder($orderId, $prepayMoney, $paymentTypeId)
    {
        $time = time() + 8 * 3600;
        $date = date('Ymdhis', $time);
        // 为保证订单号是唯一
        do {
            $paymentNo = $date . sprintf("%04d", rand(0, 9999));
            $payment = static::where('payment_no', $paymentNo)->get();
        } while ($payment->count() > 0);

        // 创建订单
        $payment = new static;
        $payment->prepay_money = $prepayMoney;
        $payment->payment_type_id = $paymentTypeId;
        $payment->order_id = $orderId;
        $payment->user_id = Auth::user()->id;
        $payment->payment_no = $paymentNo;
        $payment->save();

        return $payment;
    }

    /**
     * 支付类型
     * 模型对象关系：支付单对应的支付类型（一个支付类型对应有好几个支付条）
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentType()
    {
        //模型名 外键 本键
        return $this->belongsTo('App\Models\PaymentType', 'payment_type_id', 'id');
    }

    /**
     * 订单
     * 模型对象关系：支付单对应的订单（一个订单对应有好几个支付条）
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        //模型名 外键 本键
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }

    /**
     * 用户
     * 模型对象关系：支付单对应的用户（一个用户对应有好几个支付条）
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        //模型名 外键 本键
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * 根据支付公司返回数据更新支付表
     * @param  $payment_no   string  支付单号
     * @param  $outer_notice_sn string 支付公司返回流水号
     * @param  $money  double  支付公司返回金额
     * @return array $returnStatus     更新成功
     */
    public static function tradeResponse($request)
    {
        $payment_no = $request['out_trade_no'];
        $money = $request['total_fee'];
        $out_trade_no = $request['trade_no'];

        $returnStatus = [
            'payment_no' => $payment_no,
            'status' => true,
            'money' => $money,
        ];

        $query = [
            'payment_no' => $payment_no,
            'is_paid' => 0,
        ];
        $payment = self::where($query)->first();
        if ($payment) {
            //更新支付表
            $payment->pay_money = $money;
            $payment->is_paid = 1;
            $payment->out_trade_no = $out_trade_no;
            $payment->pay_time = Carbon::now();

            //更新用户账户余额
            $user = UserModel::find($payment->user_id);
            if ($user) {
                $user->money = $user->money + $money;
            }
            // 创建充值记录
            $rechargeLog = new RechargeLog;
            $rechargeLog->user_id = $user->id;
            $rechargeLog->amount = $money;
            $method = $payment->paymentType->name;
            $rechargeLog->method = $method;

            try {
                DB::transaction(function () use ($payment, $user, $rechargeLog) {
                    $payment->save();
                    $user->save();
                    $rechargeLog->save();
                });
            } catch (\Exception $e) {
                $requestJson = json_encode($request);
                $errmsg = '支付通知处理异常，异常信息:' . $e->getMessage() . '，请求参数：' . json_encode($request);
                Log::error($errmsg);
                DBLog::error($errmsg);
                return $returnStatus = [
                    'payment_no' => $payment_no,
                    'money' => $money,
                    'status' => false,
                ];
            }

        }

        return $returnStatus;
    }

}
