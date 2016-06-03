<?php $_fw_HTMLTitle = '流量金额充值'; $_fw_ContextPath = '../../';
$_fw_NavIndex = 1;
$_fw_MenuIndex = 1;
$_fw_AppTypeName = '云服务';
$_fw_uriPrefix = 'cloud_service';
?>
@extends('layouts.base_service')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset("res/public/css/bootstrap.min.css")}}" />
<link rel="stylesheet" type="text/css" href="{{asset("res/public/fanwe_ui.css")}}" />
<link rel="stylesheet" type="text/css" href="{{asset("res/css/m_financial_recharge.css")}}" />
@endsection

@section('scripts')
<script type='text/javascript' src='{{ asset("res/public/jquery.dateinputpack.js")  }}' charset='utf-8'></script>
<script type='text/javascript' src='{{ asset("res/public/select2.min.js")  }}' charset='utf-8'></script>

<script type="text/javascript">
$(document).ready(function(){
    $(".rechargestyle .rechargebox").bind("click",function(){
        $(this).siblings(".rechargebox").removeClass("active");
        $(this).addClass("active");
    });
    $('.btnrecharge').bind('click',function(){
        var recharge_money = $(this).parent().find("input[name='recharge_money']").val();
        /*if(recharge_money<=0){
            alert("充值金额必须大于0");
            return false;
        }
        if(recharge_money%100 != 0){
            alert("充值金额必须是100的倍数");
            return false;
        }*/
        var appid = $("input[name='appid']").val();
        var _token = $("input[name='_token']").val();
        $.ajax({
            url: '{{route("cloud_service.recharge.post")}}',
            dataType: "json",
            data:'appid='+appid+'&recharge_money='+recharge_money+'&_token='+_token,
            type: "POST",
            success:function(data, textStatus, jqXHR) {
                //var data = $.parseJSON(data);
                if(data.err == 1){
                    alert(data.msg);
                }else{
                }
                if(data.url){
                    location.href = data.url;
                }
            }
        });
        return false;
    });
});
</script>
@endsection

@section('content')
<div class="content">
<div class="tree-title">
<span><i class="iconfont">&#xe605;</i>当前位置>首页>流量红包><em>流量金额充值</em></span>
</div>

<div class="tree-content">
<div class="m-withe">
    <div class="tree-contenttitle ">
        <span>充值</span>
    </div>

    <div class="tree-padding">
       <h1>流量余额：<em>￥{{$flow_red['money']}}</em> </h1>
       <input name="appid" type="hidden" value="{{$flow_red['user_name']}}"/>
       <input name="_token" type="hidden" value="{{csrf_token()}}"/>
        <div class="blank15"></div>
        <div class="rechargetabcontent">
        	<div class="tabcontent active" rel="1">

	        <div class="list error">
	          <label>充值金额:</label>
	          <div class="input-wrap ">
	              <input type="text" class="W-input " id="" name="recharge_money" value="0">
	              <span class="holder-tip" style="display: block;"></span>
	          </div>
	          元
	        </div>

	        <div class="btnrecharge"><a class="btn defaul btn-red fit"  role="button">充值</a></div>


        	</div><!-- rel="1" -->

        </div>



    </div><!-- tree-padding end -->




</div>



</div>
@endsection
