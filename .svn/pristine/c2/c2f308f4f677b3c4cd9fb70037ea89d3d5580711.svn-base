<?php $_fw_HTMLTitle = '短信充值'; $_fw_ContextPath = '../';
$_fw_MenuIndex = 2;
$_fw_NavIndex = 1;
$_fw_AppTypeName = '云服务';
$_fw_uriPrefix = 'cloud_service';
 ?>
@extends('layouts.base_service')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset("res/public/css/bootstrap.min.css")}}" />
<link rel="stylesheet" type="text/css" href="{{asset("res/public/fanwe_ui.css")}}" />
<link rel="stylesheet" type="text/css" href="{{asset("res/css/m_financial_consumer.css")}}" />
@endsection

@section('scripts')
<script type='text/javascript' src='{{asset('res/js/select2.min.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/libs/laydate/laydate.dev.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/finance_date.js')}}' charset='utf-8'></script>
<script type="text/javascript">
function loadSmsRecharLogPage(targetUrl)
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

function loadSmsRecharLogSelectedPage(targetUrl)
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
function loadSmsConsumeLogPage(targetUrl)
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

function loadSmsConsumeLogSelectedPage(targetUrl)
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
function LoadConsumePage(targetUrl){
    $.ajax({
        url: targetUrl,
        type:'get',
        data:$(".form_consume_selected").serialize(),
        dataType: "html",
        success:function(data){
          $(".consume-ajax").html(data);
        }
      });
}

$(".tgflow").bind('click',function(){
  $(".flow").toggleClass("active");
});
$("#sms_recharge").bind('click',function(){
  var recharge_number = $("input[name='recharge_number']").val();
  var user_id = $("input[name='user_id']").val();
  $.ajax({
      url: '{{url("cloud_service/sms_recharge/recharge")}}',
      dataType: "json",
      data:'recharge_number='+recharge_number+'&user_id='+user_id,
      type: "POST",
      success:function(data, textStatus, jqXHR) {
          //var data = $.parseJSON(data);
          if(data.err == 1){
              alertWarn(data.msg);
          }else{
              if(data.url){
                  location.href = data.url;
              }
          }

      }
  });
  return false;
});

$(document).ready(function(){
    $("select.defaul").select2();
    var location = document.location.href;
      var pos = location.indexOf('#');
      var action = (pos < 0) ? '' : location.substr(pos+1);
      if (action == 'consume') {
        $(".financialtab .tab li[rel='2']").click();
      }
      loadSmsRecharLogPage('sms_recharge_log?page=1&uid='+'{{$uid}}');
      loadSmsConsumeLogPage('sms_consume_log?page=1&uid='+'{{$uid}}');

});
</script>
@endsection

@section('content')
<div class="content">
<div class="tree-title">
<span><i class="iconfont">&#xe605;</i>当前位置>云服务><em>短信充值</em></span>
</div>
<div class="tree-content financial_consumer">
    <div class="m-withe financialtit">
        <div class="f_l"><span>剩余短信：</span> </div>
        <div class="f_l"><em>@if(isset($sms_user['sms_number'])){{$sms_user['sms_number']}}@else 0 @endif</em></div>
        <div class="f_l flowbox">
          <a class="btn line btn-red f_l tgflow" href="javascript:void(0);" role="button">我要充值</a>
          <input name="_token" type="hidden" value="{{csrf_token()}}"/>
          <input name="user_id" id="user_id" type="hidden" value="{{$sms_user['id']}}"/>
          <div class="flow" style="width: 280px;">
            <div class="input-wrap f_l">
                <input type="text" class="W-input " id="" name="recharge_number" value="">
                <span class="holder-tip" style="display: inline;">输入充值数量</span>
            </div>
            <a class="btn  defaul btn-red" id="sms_recharge" role="button">确定</a>
          </div>
        </div>
        <div class="f_l" style="padding-left: 200px"><span style="color: red;">充值规则:</span><span>1、5000-1万条 8分/条;  2、1.5万-3万条 7.5分/条;  3、3.5万-5万条 7分/条;  4、5万条及以上 6.5分/条; 按5000的倍数充值</span> </div>
        <div class="blank0"></div>
    </div>

    <div class="financialtab">
        <ul class="tab">
            <li class="first active" rel="1"><a href="javascript:void(0);">充值明细</a></li>
            <li class="" rel="2"><a class="" href="javascript:void(0);">消费明细</a></li>
        </ul>
        <div class="tabcontent active" rel="1">
        <div class="m-withe">
            <form class="form_recharge" onsubmit="return false;">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="financialist1">
                <div class="list f_l timelist">
                <span class="f_l lh37">时间<i class="iconfont f_garycolor">&#xe606;</i>：</span>
                <div class="u-datepicker  f_l">
                    <div class="input-wrap">
                        <input type="text" name="recharge_start_time" class="W-input " id="activitystart1" value="" placeholder="开始时间">
                        <span class="holder-tip"></span>
                    </div>
                </div>
                <span class="f_l lh37 zhi">&nbsp;至&nbsp;</span>
                <div class="u-datepicker f_l">
                    <div class="input-wrap">
                        <input type="text" name="recharge_end_time" class="W-input " id="activityend1" value="" placeholder="结束时间">
                        <span class="holder-tip"></span>
                    </div>
                </div>
                </div>
                <a class="btn defaul  btn-default f_l" href="javascript:loadSmsRecharLogPage('sms_recharge_log?page=1&uid={{$uid}}');" role="button">查询</a>
                <div class="blank0"></div>
            </div>
            </form>
        </div>
        <div class="recharge-ajax">
          <h3>正在加载</h3>
        </div>
        </div><!-- tabcontent end -->

        <div class="tabcontent" rel="2">
        <div class="m-withe">
            <div class="financialist1">
                <form class="form_consume" onsubmit="return false;">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="list f_l timelist">
                <span class="f_l lh37">时间<i class="iconfont f_garycolor">&#xe606;</i>：</span>
                <div class="u-datepicker  f_l">
                    <div class="input-wrap">
                        <input type="text" name="consume_start_time" class="W-input " id="activitystart2" value="" placeholder="开始时间">
                        <span class="holder-tip"></span>
                    </div>
                </div>
                <span class="f_l lh37 zhi">&nbsp;至&nbsp;</span>
                <div class="u-datepicker f_l">
                    <div class="input-wrap">
                        <input type="text" name="consume_end_time" class="W-input " id="activityend2" value="" placeholder="结束时间">
                        <span class="holder-tip"></span>
                    </div>
                </div>
                </div>
                </form>
                <a class="btn defaul  btn-default f_l" href="javascript:loadSmsConsumeLogPage('sms_consume_log?page=1&uid={{$uid}}');" role="button">查询</a>
                <div class="blank0"></div>
            </div>
            <div class="consume-ajax">
              <h3>正在加载</h3>
            </div>
        </div>
        </div><!-- tabcontent end -->
    </div>

</div>


</div>
@endsection
