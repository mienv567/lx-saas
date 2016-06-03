<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{

    protected $table = 'saas_payment_type';

    /**
     * 生成该支付类型充值显示界面的HTML代码
     * @return 显示界面的HTML代码
     */
    public function getDisplayCode()
    {
        $className = 'App\Api\Payment\\' . ucfirst($this->class_name) . 'PaymentHandler';
        $paymentHander = new $className();
        $logoPath = $this->logo;
        $displayCode = $paymentHander->makeDisplayCode($logoPath);

        return $displayCode;
    }

}
