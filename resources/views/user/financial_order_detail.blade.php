<?php
$_fw_MenuIndex = 1;
$_fw_HtmlTitle = '订单详情';
?>
@extends('layouts.base')
@section('styles')
<link rel="stylesheet" type="text/css" href="../res/css/m_financial_rechargedetail.css" />
@endsection

@section('scripts')
<script type='text/javascript' src='{{asset('res/js/jquery.dateinputpack.js')}}' charset='utf-8'></script>
<script type="text/javascript">
function orderCancel(orderId) {
  $.ajax({
    url:"{{ url('user/financial_order_cancel') }}",
    type:"GET",
    data:{order_id:orderId},
    dataType: "json",
    success:function(data){
      if (data.errcode == 0) {
        var orderNo = data.orderNo;
        var content = '您的订单'+orderNo+'，已成功取消';
        alertSuccess(content);
        $('.order-status span').replaceWith('<span class="f_garycolor">已取消</span>');
        $('#order-deal').empty();
      } else if(data.errcode == 1002) {
        alertWarn(data.errmsg);
      }
    }
  })
}
function abnormalOrderDeal(orderId){
  $.ajax({
    url:"{{ url('user/abnormal_order_deal') }}",
    type:"GET",
    data:{order_id:orderId},
    dataType: "json",
    success:function(data){
      if (data.errcode == 1002 || data.errcode == 1001) {
        alertWarn(data.errmsg);
      }
      if (data.errcode == 0) {
        alertConfirm('订单完成，产品生成成功',
        function(){
        location.reload();
        },
        {okButtonText: '确定', cancelButtonText: '取消'});
      }
    }
  })
}
$(document).ready(function(){
    $(".controldetail").bind("click",function(){
        $(this).toggleClass("zclose");
        if ($(this).hasClass("zclose")) {
            $(".zfztcontent").addClass("zclose");
            $(this).find("span").text("展开扣款详情");
        }else{
            $(".zfztcontent").removeClass("zclose");
            $(this).find("span").text("收起扣款详情");
        };
    });
});
</script>

@endsection

@section('content')
<body>
<div class="content">
  <div class="tree-title">
  <span><i class="iconfont">&#xe605;</i>当前位置>首页>财务管理><em>订单详情</em></span>
  </div>
  <div class="tree-content account_setting">
    <div class="m-withe">
      <div class="tree-contenttitle ">
          <span>订单号：{{ $order->order_no }}<a class="btn line btn-default" href="{{ url('user/finance_manage') }}" role="button"><i class="iconfont">&#xe617;</i>返回列表</a></span>
      </div>
      <div class="tree-padding">
          <table class="table table-bordered tbgy">
          <thead>
              <tr>
                <th colspan="2">概要</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                <td>订单内容：{{ $order->order_topic }}</td>
                <td>订单号：{{ $order->order_no }}</td>
              </tr>
              <tr>
                <td>订单时间：{{ $order->created_at }}</td>
                <td class="order-status">订单状态:
                  @if($order->order_status == 0)
                  <span class="f_bluecolor">待支付</span>
                  @elseif($order->order_status == 1)
                  <span class="f_redcolor">已支付，未处理</span>
                  @elseif($order->order_status == 2)
                  <span class="f_greencolor">已完成</span>
                  @elseif($order->order_status == 3)
                  <span class="f_redcolor">已支付，处理异常</span>
                  @elseif($order->order_status == 4)
                  <span class="f_garycolor">已取消</span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>订单金额：￥{{ $order->order_money }}</td>
                <td>已付金额：￥{{ $order->pay_money }}</td>
              </tr>

          </tbody>
          </table>
@if($payments->count() != 0 or $consumes->count() != 0)
          <div class="zfzt">
            <div class="zfztcontent">
            <table class="table table-hover tbgydetail">
            <thead>
                <tr>
                  <th>流水号</th>
                  <th>支付方式</th>
                  <th>金额</th>
                  <th>支付时间</th>
                </tr>
            </thead>
            <tbody>
              @foreach($payments as $payment)
                <tr>
                  <td>{{ $payment->out_trade_no }}</td>
                  <td>{{ $payment->paymentType->name }}</td>
                  <td><span class="f_bluecolor">￥{{ $payment->pay_money }}</span> </td>
                  <td>{{ $payment->pay_time }}</td>
                </tr>
              @endforeach
              @foreach($consumes as $consume)
                <tr>
                  <td>——</td>
                  <td>余额支付</td>
                  <td><span class="f_bluecolor">￥{{ $consume->amount }}</span> </td>
                  <td>{{ $consume->created_at }}</td>
                </tr>
              @endforeach
            </tbody>
            </table>
            </div>
            <div class="blank15"></div>
        </div>
@endif
        <div class="zfzt">
          {!! $orderDetail !!}
        </div>
      </div>
    </div>
    <div style="margin-top:15px;" id="order-deal">
    @if($order->order_status == 0)
      <a class="btn line btn-red f_l" href="{{ url('user/financial_pay') }}?order_id={{$order->id}}" role="button">立即支付</a>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <a class="btn line btn-red" href="javascript:alertConfirm(' 您真的要取消吗？',function(){
      orderCancel({{$order->id}});
      },{okButtonText: '确定', cancelButtonText: '取消'});" role="button">取消订单</a>
      @elseif($order->order_status == 3 or $order->order_status == 1)
      <a class="btn line btn-red f_l" href="
      javascript:abnormalOrderDeal({{ $order->id }})">立即处理</a>
    @endif
    </div>
  </div>
</div>
</body>
@endsection
