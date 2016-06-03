<?php $_fw_MenuIndex = 1;?>
<?php $orderPayMoney = number_format($order->order_money - $order->pay_money, 2);?>
@extends('layouts.base')
@section('styles')
<link rel="stylesheet" type="text/css" href="../res/css/system_payment.css" />
@endsection

@section('scripts')
<script type="text/javascript">
<<<<<<< .mine
function checkbox(key){
  var check = document.getElementById('checkbox-' + key);
  if (check.checked) {
    $('#w-input-' + key).attr("value",{{ round($order->order_money - $order->pay_money,2) }});
    $('#w-input-' + key).attr('disabled',true);
    $('#div-checkbox-'+key).append('<input type="hidden" name="payForAccount"></input>');
  } else {
    $('#w-input-' + key).attr("value",0);
    $('#w-input-' + key).attr('disabled',false);
    $('#div-checkbox-'+key).empty();
  }
}

function handlePay(key) {
=======
function orderPayForAccount(){
>>>>>>> .r650
  $.ajax({
    url: '{{ url('user/financial_pay_for_account') }}',
    type:'POST',
    data:$("#order-form").serialize(),
    dataType: "json",
    error:function(){
      w.close();
    },
    success:function(data){
<<<<<<< .mine
      if (data.status == 0) {
        // window.open();
        // w.location = "{{ url('a') }}";
          $(".form_hidden").html(data.code);
          $(".form_hidden form").submit();
      }
=======
      //支付完
>>>>>>> .r650
      if (data.status == 1) {
        // w.close();
        window.location.reload();
      }
      //余额不够全额支付
      if (data.status == 2) {
        var needPay = {{ $orderPayMoney }} - data.amount;
        $('#account').html(data.amount); // 账户余额更新
        //支付金额更新
        $('#pay-for-account').html(data.amount);
        $("input[name=accountPay]").attr('value',data.amount)
        $('#need-pay').html(needPay); // 还需支付金额更新
        alertWarn(data.note);
      }
      //支付异常
      if (data.status == 4) {
        alertWarn(data.note);
      }
    }
  });
}

<<<<<<< .mine

function orderPayConfirm(key,orderId) {
=======
function orderPayConfirm(orderId) {
>>>>>>> .r650
  var accountPay = $("input[name=accountPay]").val(); //余额支付金额
  var orderPayMoney = {{ $orderPayMoney }}; // 产品应付金额
  console.log(accountPay);
  console.log(orderPayMoney);
  if (accountPay == orderPayMoney) {
    // 如果余额支付金额等于产品应付金额
    orderPayForAccount();
  } else if( accountPay < orderPayMoney) {
    // 如果余额支付金额小于产品应付金额,剩余金额需要到在线支付
    console.log(2);
    $("#order-form").submit();
    var content = '<p class="ml1"> 请您在新打开的页面完成付款。</p>'
                + '<p class="ml2 f_redcolor"> 付款完成前请不要关闭此窗口。</p>'
                + '<p> 完成付款后请根据您的情况点击下面的按钮：</p>'
                ;
    alertConfirm(
      content,
      function(){
        window.location.href="{{ url('user/financial_pay_check') }}?order_id="+orderId;
      },
      {okButtonText: '已完成付款', cancelButtonText: '重新发起支付'}
    );
  }
}
  var orderPay = {{ round($order->order_money - $order->pay_money,2) }};
function checkAccount(){
  var check = document.getElementById('check-account');
  var account = {{ $account }};
  var orderPayMoney = {{ $orderPayMoney }};
  if (check.checked) {
    if (account >= orderPayMoney) {
      var orderPayMoney = orderPayMoney.toFixed(2);
      $('#pay-for-account').html('-￥'+orderPayMoney);
      $("input[name=accountPay]").attr('value',orderPayMoney);
      $('#need-pay').html('0.00');
    } else {
      var needPay = (orderPayMoney-account).toFixed(2);
      var account = account.toFixed(2);
      $('#pay-for-account').html('-￥'+account);
      $("input[name=accountPay]").attr('value',account);
      $('#need-pay').html(needPay);
    }

  } else {
    var orderPayMoney = orderPayMoney.toFixed(2);
    $('#need-pay').html(orderPayMoney);
    $('#pay-for-account').html('￥0.00');
    $("input[name=accountPay]").attr('value',0);
  }
<<<<<<< .mine
  // $("#form_" + key).submit();
  if (value == orderPay) {
    orderPayForAccount(key,orderId);
  } else if( value < orderPay) {
    $("#form_" + key).submit();
    var content = '<p class="ml1"> 请您在新打开的页面完成付款。</p>'
                + '<p class="ml2 f_redcolor"> 付款完成前请不要关闭此窗口。</p>'
                + '<p> 完成付款后请根据您的情况点击下面的按钮：</p>'
                ;
    alertConfirm(
      content,
      function(){
        window.location.href="{{ url('user/financial_pay_check') }}?order_id="+orderId;
      },
      {okButtonText: '已完成付款', cancelButtonText: '重新发起支付'}
    );
  }

=======
>>>>>>> .r650
}

function orderPayForAccount(key,orderId){
  var value = document.getElementById("w-input-"+key).value;
  $.ajax({
    url: '{{ url('user/financial_pay_for_account') }}',
    type:'POST',
    data:$("#form_" + key).serialize(),
    dataType: "json",
    success:function(data){
      //支付完
      if (data.status == 1) {
        window.location.reload();
      }
      //余额不够全额支付
      if (data.status == 2) {
        $('.salesprice').replaceWith('<em class="salesprice">'+data.amount+'</em>');
        $('#w-input-'+key).attr('value', data.amount);
        $('#w-input-'+key).attr('disabled', false);
        $('#checkbox-'+key).attr('checked', false);
        alertWarn(data.note);
      }
      if (data.status == 4) {
        alertWarn(data.note);
      }
    }
  });
}
</script>

@endsection

@section('content')
<body>
  <div class="content">
    <div class="tree-title">
    <span><i class="iconfont">&#xe605;</i>当前位置>财务管理><em>支付页面</em></span>
    </div>
    <div class="tree-content system_payment">
    <div class="m-withe">
        <div class="redtit">
            <span>选购商品</span>
        </div>
        <div class="paymentlist">
        <table class="table table-hover">
        <thead>
            <tr>
              <th width="45%">产品信息</th>
              @if($order->pay_money != 0)
              <th width="10%">总金额</th>
              <th width="10%">已付金额</th>
              @endif
              <th width="10%">应付金额</th>
            </tr>
        </thead>
        <tbody>
            <tr>
              <td>{{$order->order_topic}}</td>
              @if($order->pay_money != 0)
              <td class="f_redcolor">￥{{ $order->order_money }}</td>
              <td class="f_redcolor">￥{{ $order->pay_money }}</td>
              @endif
              <td class="f_redcolor">￥{{ number_format($order->order_money - $order->pay_money,2) }}</td>
            </tr>
        </tbody>
        </table>
        </div>

        <div class="form_hidden" style="display:none"></div>
        <div class="blank15"></div>
        <div class="redtit">
            <span>选择支付方式</span>
        </div>
         <div class="paymenttab">
            <div class="rechargetabcontent">
@foreach ($paymentTypes as $key => $paymentType)
              <div class="tabcontent @if ($key == 0) active @endif" rel="{{ $paymentType->id }}">
                <div class="rechargestyle warmtip">
                  {!! $paymentType->getDisplayCode() !!}
                  <div class="blank0"></div>
                </div>
              </div>
@endforeach
            </div><!-- rechargetabcontent end -->
          </div><!-- paymenttab end -->
          <form id="order-form" method="POST" action="{{ url('user/financial_pay_handle')}}" target="_blank">
          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
          <input id="paymentTypeId" type="hidden" name="paymentTypeId" value="1">
          <input type="hidden" name="orderId" value="{{ $order->id }}">
          <input type="hidden" name="orderPayMoney" value="{{ $orderPayMoney }}">
          <div class="yezf">
            <div class="detaillist">
                <span  class="f_redcolor">1</span> 件商品，<label>商品金额：</label>
                <div class="f_redcolor money">￥{{ number_format($order->order_money,2) }}</div>
            </div>
@if($order->pay_money != 0)
            <div class="detaillist">
                <label>已付金额：</label>
                <div class="money">-￥{{ number_format($order->pay_money,2) }}</div>
            </div>
@endif
            <div class="detaillist">
                <div class="useyepay">
                    <label>
@if($account != 0 or $order->order_money == 0)
                    <input type="checkbox" id="check-account" onclick="checkAccount();" checked="checked">使用余额支付（可使用余额 <span id="account">{{ number_format($account,2) }} </span>元）：
  @if($account >= $orderPayMoney)
                    <span id="pay-for-account" class="money">-￥{{ $orderPayMoney }}</span>
                    <input type="hidden" name="accountPay" value="{{ $orderPayMoney }}">
  @else
                    <span id="pay-for-account" class="money">-￥{{ $account }}</span>
                    <input type="hidden" name="accountPay" value="{{ $account }}">
  @endif

@else
                    <input type="checkbox" disabled=true>使用余额支付（可使用余额<span>{{ $account }}</span>元）：
                    <input type="hidden" name="accountPay" value="0">
                    <span id="pay-for-account" class="money">-￥0.00</span>
@endif
                    </label>
                </div>
<<<<<<< .mine
                <div class="submitbox">
                  <div id="order-submit-{{ $key }}">
                    <input class="btn defaul fit btn-red f_r z-openmarker" onclick="javascript:orderPayConfirm({{ $key }},{{$order->id}});" type="button" value="立即提交">
                  </div>
                    <div class="con"><span id="num">1</span> 件商品，应付金额：<span>￥<em id="summoney">{{ round($order->order_money - $order->pay_money,2) }}</em></span> </div>
                    <div class="blank0"></div>
=======
            </div>

            <div class="detaillist">
                <div class="useyepay">
                  <span class="tczf">您还需支付：</span>
@if($account > $orderPayMoney)
                  <span class="f_redcolor money">￥<em class="salesprice" id="need-pay">0.00</em></span>
@else
                  <span class="f_redcolor money">￥<em class="salesprice" id="need-pay">{{ number_format($orderPayMoney - $account,2) }}</em></span>
@endif
>>>>>>> .r650
                </div>
            </div>
          </div>
          <div class="submitbox">
              <input class="btn defaul fit btn-red f_r z-openmarker" onclick="javascript:orderPayConfirm({{$order->id}});" type="button" value="立即支付">
              <div class="blank0"></div>
          </div>
          </form>
    </div><!--m-withe end-->
    </div><!--tree-content end-->
  </div><!-- content end-->
</body>
@endsection
