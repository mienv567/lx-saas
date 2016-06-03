<?php $_fw_MenuIndex = 1;?>
@extends('layouts.base')
@section('styles')
<link rel="stylesheet" type="text/css" href="../res/css/m_financial_recharge.css" />
@endsection

@section('scripts')
<script type='text/javascript' src='{{asset('res/js/jquery.dateinputpack.js')}}' charset='utf-8'></script>
<script type="text/javascript">
$(document).ready(function(){
    $(".rechargestyle .rechargebox").bind("click",function(){
        $(this).siblings(".rechargebox").removeClass("active");
        $(this).addClass("active");
    });
});
</script>

@endsection

@section('content')
<body>
<div class="content">
<div class="tree-title">
<span><i class="iconfont">&#xe605;</i>当前位置>首页>财务管理><em>支付成功</em></span>
</div>

<div class="tree-content">
<div class="m-withe">

<div class="successpadding">
  <div class="successbk">
    <i class="iconfont f_greencolor">&#xe610;</i>
    <h4>支付成功</h4>
    <h6>订单号：{{$order->order_no}}<span></span>支付金额：{{$order->pay_money}}元<span></span>操作时间：{{$order->updated_at}}</h6>
    @if ($order->pay_money > $order->order_money)
    <h6>超额支付: ￥{{ round($order->pay_money - $order->order_money,2) }},已充值到您的账户余额 !</h6>
    @endif
    <form action="{{ url('user/financial_order_detail') }}" method="post">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="order_id" value="{{ $order->id }}"></input>
        <input class="btn line btn-default lookdetail" type="submit" value="查看订单详情"></input>
    </form>
  </div>
</div><!-- successpadding end -->
</div>
</div>
</div>
</body>
@endsection
