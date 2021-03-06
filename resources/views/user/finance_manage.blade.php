<?php
$_fw_MenuIndex = 1;
$_fw_HtmlTitle = '财务管理';
?>
@extends('layouts.base')
@section('styles')
<link rel="stylesheet" type="text/css" href="../res/css/m_financial_consumer.css" />
@endsection

@section('scripts')
<script type='text/javascript' src='{{asset('res/js/select2.min.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/libs/laydate/laydate.dev.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/finance_date.js')}}' charset='utf-8'></script>
<script type="text/javascript">
function loadRecharLogPage(targetUrl)
{
    $.ajax({
      url: targetUrl,
      type:'get',
      data:$(".form_recharge").serialize(),
      dataType: "html",
      success:function(data){
        $(".recharge-ajax").html(data);
      }
    });
}

function loadRecharLogSelectedPage(targetUrl)
{
  var recharPage = $("#recharge-page").val();
    $.ajax({
      url: targetUrl+recharPage,
      type:'get',
      data:$(".form_recharge_selected").serialize(),
      dataType: "html",
      success:function(data){
        $(".recharge-ajax").html(data);
      }
    });
}

function loadConsumeLogPage(targetUrl)
{
  $.ajax({
    url: targetUrl,
    type:'get',
    data:$(".form_consume").serialize(),
    dataType: "html",
    success:function(data){
      $(".consume-ajax").html(data);
    }
  });
}

function loadConsumeLogSelectedPage(targetUrl)
{
  var consumePage = $("#consume-page").val();
  $.ajax({
    url: targetUrl+consumePage,
    type:'get',
    data:$(".form_consume_selected").serialize(),
    dataType: "html",
    success:function(data){
      $(".consume-ajax").html(data);
    }
  });
}

function loadOrderLogPage(targetUrl)
{
  $.ajax({
    url: targetUrl,
    type:'get',
    data:$(".form_order").serialize(),
    dataType: "html",
    success:function(data){
      $(".order-ajax").html(data);
    }
  });
}

function loadOrderLogSelectedPage(targetUrl)
{
  var orderPage = $("#order-page").val();
  $.ajax({
    url: targetUrl+orderPage,
    type:'get',
    data:$(".form_order_selected").serialize(),
    dataType: "html",
    success:function(data){
      $(".order-ajax").html(data);
    }
  });
}

$(document).ready(function(){
  var location = document.location.href;
  var pos = location.indexOf('#');
  var action = (pos < 0) ? '' : location.substr(pos+1);
  if (action == 'recharge') {
    $(".financialtab .tab li[rel='2']").click();
  } else if (action == 'consume') {
    $(".financialtab .tab li[rel='3']").click();
  }
  loadRecharLogPage('financial_recharge_log?page=1');
  loadConsumeLogPage('financial_consume_log?page=1');
  loadOrderLogPage('financial_order_log?page=1');
  $("select.defaul").select2();
});
</script>

@endsection

@section('content')
<body>
<div class="content" id="content">
<div class="tree-title">
<span><i class="iconfont">&#xe605;</i>当前位置>首页><em>财务管理</em></span>
</div>
<div class="tree-content financial_consumer">
    <div class="m-withe financialtit">
        <div class="f_l"><span>账户余额：</span> </div>
        <div class="f_l"><em>{{ $money }}</em></div>
        <a class="btn line btn-red f_l" href="{{ url('user/financial_recharge') }}" role="button">我要充值</a>
        <div class="blank0"></div>
    </div>

    <div class="financialtab">
        <ul class="tab">
            <li class="first active" rel="1"><a href="javascript:void(0);">订单明细</a></li>
            <li class="" rel="2"><a class="" href="javascript:void(0);">充值明细</a></li>
            <li class="" rel="3"><a class="" href="javascript:void(0);">消费明细</a></li>
        </ul>
        <div class="tabcontent active" rel="1">
          <div class="m-withe">
            <div class="financialist1">
              <form class="form_order" onsubmit="return false;">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="list f_l">
                <span class="f_l lh37">关键字：</span>
                <div class="input-wrap f_l">
                    <input type="text" class="W-input " name="order_key" value="">
                    <span class="holder-tip" style="display: inline;">订单号或订单内容</span>
                </div>
                </div>
                <div class="list f_l">
                <span>订单状态：</span>
                <select class="defaul" name="order_status">
                  <option value="-1">全部</option>
                  <option value="0">待支付</option>
                  <option value="1">已支付，未处理</option>
                  <option value="2">已完成</option>
                  <option value="3">已支付，处理异常</option>
                  <option value="4">已取消</option>
                </select>
                </div>
                <div class="list f_l timelist">
                <span class="f_l lh37">时间<i class="iconfont f_garycolor">&#xe606;</i>：</span>
                <div class="u-datepicker  f_l">
                    <div class="input-wrap">
                        <input type="text" name="order_start_time" class="W-input " id="activitystart1" value="" placeholder="开始时间">
                        <span class="holder-tip"></span>
                    </div>
                </div>
                <span class="f_l lh37 zhi">&nbsp;至&nbsp;</span>
                <div class="u-datepicker">
                    <div class="input-wrap">
                        <input type="text" name="order_end_time" class="W-input " id="activityend1" value="" placeholder="结束时间">
                        <span class="holder-tip"></span>
                    </div>
                </div>
                </div>
                <a class="btn defaul  btn-default f_l" href="javascript:loadOrderLogPage('financial_order_log?page=1');" role="button">查询</a>
                <div class="blank0"></div>
              </form>
            </div>
              <div class="order-ajax">
                <div class="load-ajax">正在加载</div>
              </div>
          </div>
        </div><!-- tabcontent end -->

        <div class="tabcontent" rel="2">
          <div class="m-withe">
          <div class="financialist1">
            <form class="form_recharge" onsubmit="return false;">
              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
              <div class="list f_l timelist">
              <span class="f_l lh37">时间<i class="iconfont f_garycolor">&#xe606;</i>：</span>
              <div class="u-datepicker f_l">
                  <div class="input-wrap">
                      <input type="text" name="recharge_start_time" class="W-input " id="activitystart2" value="" placeholder="开始时间">
                      <span class="holder-tip"></span>
                  </div>
              </div>
              <span class="f_l lh37 zhi">&nbsp;至&nbsp;</span>
              <div class="u-datepicker">
                  <div class="input-wrap">
                      <input type="text" name="recharge_end_time" class="W-input " id="activityend2" value="" placeholder="结束时间">
                      <span class="holder-tip"></span>
                  </div>
              </div>
              </div>
              <a class="btn defaul  btn-default f_l" href="javascript:loadRecharLogPage('financial_recharge_log?page=1');" role="button">查询</a>
              <div class="blank0"></div>
            </form>
          </div>
            <div class="recharge-ajax">
              <div class="load-ajax">正在加载</div>
            </div>
          </div>
        </div><!-- tabcontent end -->

        <div class="tabcontent" rel="3">
          <div class="m-withe">
            <div class="financialist1">
              <form class="form_consume" onsubmit="return false;">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="list f_l">
                <span>支付类型：</span>
                <select class="defaul" name="consume_status">
                  <option value="-1">全部</option>
                  <option value="0">余额支付</option>
                  <option value="1">在线支付</option>
                </select>
                </div>
                <div class="list f_l timelist">
                <span class="f_l lh37">时间<i class="iconfont f_garycolor">&#xe606;</i>：</span>
                <div class="u-datepicker f_l">
                    <div class="input-wrap">
                        <input type="text" name="consume_start_time" class="W-input " id="activitystart3" value="" placeholder="开始时间">
                        <span class="holder-tip"></span>
                    </div>
                </div>
                <span class="f_l lh37 zhi">&nbsp;至&nbsp;</span>
                <div class="u-datepicker">
                    <div class="input-wrap">
                        <input type="text" name="consume_end_time" class="W-input " id="activityend3" value="" placeholder="结束时间">
                        <span class="holder-tip"></span>
                    </div>
                </div>
                </div>
                <a class="btn defaul  btn-default f_l" href="javascript:loadConsumeLogPage('financial_consume_log?page=1');" role="button">查询</a>
                <div class="blank0"></div>
              </form>
            </div>
            <div class="consume-ajax">
              <div class="load-ajax">正在加载</div>
            </div>
          </div>
        </div><!-- tabcontent end -->

    </div>
</div>

</div>
@endsection
