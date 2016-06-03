<?php $_fw_MenuIndex = 1;?>
@extends('layouts.base')
@section('styles')
<link rel="stylesheet" type="text/css" href="../res/css/m_financial_recharge.css" />
@endsection

@section('scripts')
<script type="text/javascript">
  var i = 4;
  var intervalid;
  intervalid = setInterval("fun()", 1000);
  function fun() {
    if (i == 0) {
    window.location.href = "{{ url('user/financial_recharge') }}";
    clearInterval(intervalid);
    }
    document.getElementById("mes").innerHTML = i;
    i--;
  }
</script>
@endsection

@section('content')
<body>
  <div class="content">
    <div class="tree-title">
    <span><i class="iconfont">&#xe605;</i>当前位置>财务管理><em>充值</em></span>
    </div>
    <div class="tree-content">
      <div class="m-withe">
      <div class="successpadding">
          <div class="successbk">
              <i class="iconfont f_orangecolor">&#xe61b;</i>
              <h4>操作错误</h4>
              <h6>付款未完成，如果您已经支付请进入相应支付平台重新通知</h6>
              <h6>系统将在<em class="f_orangecolor" id="mes" style="font-size:18px;margin: 0 5px;">4</em>秒后自动跳转</h6>
              <a class="btn line btn-default lookdetail" href="{{ url('user/financial_recharge')}}" role="button">点击返回</a>
          </div>
      </div><!-- successpadding end -->
      </div>
    </div>
  </div><!-- content end-->

</body>

@endsection
