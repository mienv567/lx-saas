<?php

namespace App\Listeners;

use App\Models\Message;
use App\Models\MessageTemplate;

/**
 * Class UserEventHandler
 * (管理)订单处理活动事件监听器
 */
class OrderEventListener
{

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        //这里需申明完整类路径，否则会出现'Class UserEventListener does not exist'错误
        $events->listen('App\Events\OrderFailDeal', 'App\Listeners\OrderEventListener@onOrderFailDeal');

        $events->listen('App\Events\OrderSuccCloudSystem', 'App\Listeners\OrderEventListener@onOrderSuccCloudSystem');

        $events->listen('App\Events\OrderSuccCloudPlatform', 'App\Listeners\OrderEventListener@onOrderSuccCloudPlatform');

        $events->listen('App\Events\OrderSuccServiceLlhb', 'App\Listeners\OrderEventListener@onOrderSuccServiceLlhb');
    }

    /**
     * 订单处理失败
     * @param  App\Events\ $event 事件
     * @return void
     */
    public function onOrderFailDeal($event)
    {
        $messageTemplate = MessageTemplate::where('event', 'ORDER_FAIL_DEAL')->get();
        if ($messageTemplate->count() != 0) {
            $order = $event->order;
            $content = '您的订单（订单号：' . $order['order_no'] . '）已支付成功，但订单处理失败，请点击 <a>此处</a> 到订单详情页中点击【立即处理】按钮再次处理，若再次处理失败，请与客服人员联系！';
            $message = new Message;
            $message->title = '订单处理失败提醒';
            $message->user_id = $order->user_id;
            $message->msgtype = 0;
            $message->content = $content;
            $message->save();
        }
    }

    /**
     * 云系统订单完成
     * @param  App\Events\ $event 事件
     * @return void
     */
    public function onOrderSuccCloudSystem($event)
    {
        $messageTemplate = MessageTemplate::where('event', 'ORDER_SUCC_CLOUD_SYSTEM')->get();
        if ($messageTemplate->count() != 0) {
            $order = $event->order;
            $content = ' 您的订单（订单号：' . $order['order_no'] . '）已完成，订单产品已生成，您可以在<a>【云系统】</a> -> <a>【我的应用】</a>中找到该产品，并可点击该产品的<a>【设置管理】</a>按钮进行产品管理和维护。';
            $message = new Message;
            $message->title = '云系统产品购买成功提醒';
            $message->user_id = $order->user_id;
            $message->msgtype = 0;
            $message->content = $content;
            $message->save();
        }
    }

    /**
     * 云平台订单完成
     * @param  App\Events\ $event 事件
     * @return void
     */
    public function onOrderSuccCloudPlatform($event)
    {
        $messageTemplate = MessageTemplate::where('event', 'ORDER_SUCC_CLOUD_PLATFORM')->get();
        if ($messageTemplate->count() != 0) {
            $order = $event->order;
            $content = '您的订单（订单号：' . $order['order_no'] . '）已完成，订单产品已生成，您可以在<a>【云平台】</a> -> <a>【我的应用】</a>中找到该产品，并可点击该产品的<a>【设置管理】</a>按钮进行产品管理和维护。';
            $message = new Message;
            $message->title = '云平台产品购买成功提醒';
            $message->user_id = $order->user_id;
            $message->msgtype = 0;
            $message->content = $content;
            $message->save();
        }
    }

    /**
     * 流量红包充值
     * @param  App\Events\ $event 事件
     * @return void
     */
    public function onOrderSuccServiceLlhb($event)
    {
        $messageTemplate = MessageTemplate::where('event', 'ORDER_SUCC_SERVICE_LLHB')->get();
        if ($messageTemplate->count() != 0) {
            $order = $event->order;
            $content = '您的订单（订单号：' . $order['order_no'] . '）已完成，已成功充值' . $order['order_money'] . '元的流量红包。';
            $message = new Message;
            $message->title = '流量红包充值成功提醒';
            $message->user_id = $order->user_id;
            $message->msgtype = 0;
            $message->content = $content;
            $message->save();
        }
    }

}
