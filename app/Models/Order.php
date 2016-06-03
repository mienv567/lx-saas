<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'saas_order';

    /**
     * 支付条
     * 模型对象关系：订单对应的支付条（一个订单可能有几个支付条）
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payments()
    {
        //模型名 外键 本键
        return $this->hasMany('App\Models\Payment', 'order_id', 'id');
    }

    /**
     * 消费条
     * 模型对象关系：订单对应的消费条（一个订单可能有几个消费条）
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consumes()
    {
        //模型名 外键 本键
        return $this->hasMany('App\Models\ConsumeLog', 'order_id', 'id');
    }

    /**
     * 用户
     * 模型对象关系：订单对应的用户（一个用户可能有几个订单）
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        //模型名 外键 本键
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

}
