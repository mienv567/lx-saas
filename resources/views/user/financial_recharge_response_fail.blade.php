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
<span><i class="iconfont">&#xe605;</i>当前位置>首页>财务管理><em>充值成功</em></span>
</div>

<div class="tree-content">
<div class="m-withe">

<div class="successpadding">
  <div class="successbk">
    <h4 style="color: #f00">支付成功，但订单处理异常，请与客服联系</h4>
    <h6>订单号：{{ $payment->payment_no }}<span></span>支付金额：{{ $money }}元<span></span>操作时间：{{ date("Y-m-d h:i", strtotime(trim($payment->pay_time))) }}</h6>
  </div>
</div><!-- successpadding end -->

</div>

</div>
</body>
@endsection
