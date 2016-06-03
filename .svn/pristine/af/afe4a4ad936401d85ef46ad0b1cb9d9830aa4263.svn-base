<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumeLog extends Model
{

    protected $table = 'saas_consume_log';

    /**
     * 订单
     * 模型对象关系：消费记录对应的订单（一个订单可能有几个消费记录）
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        //模型名 外键 本键
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }

}
