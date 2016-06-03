<?php $_fw_HTMLTitle = '流量红包'; $_fw_ContextPath = '../';
$_fw_MenuIndex = 1;
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
function loadFlowRecharLogPage(targetUrl)
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

function loadFlowRecharLogSelectedPage(targetUrl)
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

function loadFlowConsumeLogPage(targetUrl)
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

function loadFlowConsumeLogSelectedPage(targetUrl)
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
$("#recharge").bind('click',function(){
  var recharge_money = $("input[name='recharge_money']").val();
  var _token = $("input[name='_token']").val();
  $.ajax({
      url: '{{route("cloud_service.recharge.post")}}',
      dataType: "json",
      data:'recharge_money='+recharge_money+'&_token='+_token,
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
      loadFlowRecharLogPage('flow_red_recharge_log?page=1');
      loadFlowConsumeLogPage('flow_red_consume_log?page=1');

});
</script>
@endsection

@section('content')
<div class="content">
<div class="tree-title">
<span><i class="iconfont">&#xe605;</i>当前位置>云服务><em>手机流量</em></span>
</div>
<div class="tree-content financial_consumer">
    <div class="m-withe financialtit">
        @if(isset($flow_red['id']) && $flow_red['id']>0)
        <div class="f_l"><span>流量余额：</span> </div>
        <div class="f_l"><em>{{round($flow_red['money'],2)}}</em></div>
        <div class="f_l flowbox">
          <a class="btn line btn-red f_l tgflow" href="javascript:void(0);" role="button">我要充值</a>
          <input name="_token" type="hidden" value="{{csrf_token()}}"/>
          <div class="flow">
            <div class="input-wrap f_l">
                <input type="text" class="W-input " id="" name="recharge_money" value="">
                <span class="holder-tip" style="display: inline;">输入充值金额</span>
            </div>
            <a class="btn  defaul btn-red" id="recharge" role="button">确定</a>
          </div>
        </div>
        @else
        <div class="f_l"><span>需要购买流量红包应用后才能充值</span> </div>
        <a class="btn line btn-red f_l" href="{{url('cloud_platform')}}" role="button">去购买</a>
        @endif
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
                <a class="btn defaul  btn-default f_l" href="javascript:loadFlowRecharLogPage('flow_red_recharge_log?page=1');" role="button">查询</a>
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
                <a class="btn defaul  btn-default f_l" href="javascript:loadFlowConsumeLogPage('flow_red_consume_log?page=1');" role="button">查询</a>
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
