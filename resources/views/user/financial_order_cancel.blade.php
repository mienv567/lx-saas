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
    <span><i class="iconfont">&#xe605;</i>当前位置>首页>财务管理><em>订单取消</em></span>
    </div>

    <div class="tree-content">
      <div class="m-withe">

        <div class="successpadding">
          <div class="blank10"></div>
          <div class="successbk">
              <i class="iconfont f_orangecolor">&#xe61b;</i>
              <h4>您的订单已被取消</h4>
              @if($payMoney)
              <h6>您订单已支付的金额￥{{ $payMoney }}，已经退到您的账户余额。</h6>
              @endif
              <h6><a class="a-link" href="javascript:window.location.href = document.referrer;">返回到上一页</a></h6>
          </div>
        </div><!-- successpadding end -->
      </div>
    </div>
  </div>
</body>
@endsection
