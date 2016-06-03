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
<link rel="stylesheet" type="text/css" href="{{asset('res/css/account_setting.css')}}" />
@endsection

@section('scripts')
<script type='text/javascript' src='{{asset('res/js/select2.min.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/libs/laydate/laydate.dev.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/finance_date.js')}}' charset='utf-8'></script>
<script type="text/javascript">

$("#button-add").bind('click',function() {
  var query = $("#form-add").serialize();
  var ajaxurl = '{{url('cloud_service/sms_user/bind')}}';
  if($("#type").val()=='add'){
      ajaxurl = '{{url('cloud_service/sms_user/store')}}';
  }
  $.ajax({
      url: ajaxurl,
      dataType: "json",
      data:query,
      type: "POST",
      success:function(data, textStatus, jqXHR) {
          //var data = $.parseJSON(data);
          if(data.status == 0){
              alertWarn(data.msg);
          }else{
              alertSuccess(data.msg);
              setTimeout(location.href = '{{url("cloud_service/sms_user")}}',2000);
          }
      }
  });
  return false;
});

function sign_add(obj){
    var sign = $.trim(obj.value);
    if(sign!=''){
        if(sign.substr(0,1)!='【'){
            sign = '【' + sign;
        }
        if(sign.substr(-1)!='】'){
            sign =  sign+'】';
        }
        $('#sign').val(sign);
    }
}

function sign_del(obj){
    var sign = $.trim(obj.value);
    if(sign!=''){
        if(sign.substr(0,1)=='【'){
            sign = sign.substr(1);
        }
        if(sign.substr(-1)=='】'){
            sign =  sign.substr(0,sign.length-1)
        }
        $('#sign').val(sign);
    }
}

</script>
@endsection

@section('content')
<div class="content">
<div class="tree-title">
<span><i class="iconfont">&#xe605;</i>当前位置>云服务>短信账号>@if($type=='add')<em>账号添加</em>@else<em>账号绑定</em>@endif</span>
</div>


<div class="tree-content account_setting">
    <div class="m-withe">
        <div class="tree-contenttitle ">
            @if($type=='add')
            <span>账号添加</span>
            @else
            <span>账号绑定</span>
            @endif
        </div>
        <input type="hidden" name="type" id="type" value="{{$type}}"/>
        <form id="form-add" method="post" action="">
        <div class="tree-contentlist">
            <div class="list name">
                <label class="caption"><em class="f_redcolor">*</em>账号名称：</label>
                <div class="input-wrap">
                    <input type="text" class="W-input " id="user_name" name="user_name" value="" placeholder="请输入账号名称">
                </div>
            </div>
            <div class="list name">
                <label class="caption"><em class="f_redcolor">*</em>账号密码：</label>
                <div class="input-wrap">
                    <input type="password" class="W-input " id="user_pwd" name="user_pwd" value="" placeholder="密码长度为6-20个字符">
                </div>
            </div>
            @if($type=='add')
            <div class="list">
                <label class="caption"><em class="f_redcolor">*</em>产品名称：</label>
                <div class="form-group ">
                    <select class="stlectdefault form-control" style="width: auto;" id="product" name="product">
                        <option value="默认">默认</option>
                        <option value="o2o">o2o</option>
                        <option value="p2p">p2p</option>
                        <option value="订餐">订餐</option>
                        <option value="众筹">众筹</option>
                        <option value="一元购">一元购</option>
                        <option value="其它">其它</option>
                    </select>
                </div>
            </div>
            <div class="list ">
                <label class="caption"><em class="f_redcolor">*</em>账号签名：</label>
                <div class="input-wrap">
                    <input type="text" class="W-input " id="sign" name="sign" onfocus="sign_del(this)" onblur="sign_add(this)" value="" placeholder="请输入账号签名">
                </div>
            </div>
            @endif
            <div class="list save error">
                @if($type=='add')
                <a class="btn fit  defaul btn-red" id="button-add"  role="button">添加</a>
                @else
                <a class="btn fit  defaul btn-red" id="button-add"  role="button">绑定</a>
                @endif
            </div>
        </div>
        </form>

    </div>


</div>
</div>
@endsection
