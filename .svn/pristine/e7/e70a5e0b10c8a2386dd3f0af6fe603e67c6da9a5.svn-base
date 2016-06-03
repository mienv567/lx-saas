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

$("#button-edit").bind('click',function() {
  var query = $("#form-edit").serialize();
  $.ajax({
      url: '{{url('cloud_service/sms_user/update')}}',
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
<span><i class="iconfont">&#xe605;</i>当前位置>云服务>短信账号><em>账号编辑</em></span>
</div>


<div class="tree-content account_setting">
    <div class="m-withe">
        <div class="tree-contenttitle ">
            <span>账号编辑</span>
        </div>
        <form id="form-edit" method="post" action="">
        <input type="hidden" name="id" value="{{$sms_user['id']}}"/>
        <div class="tree-contentlist">
            <div class="list name">
                <label class="caption"><em class="f_redcolor">*</em>账号名称：</label>
                <div class="input-wrap" style="border:none;padding-top: 10px;">
                    <span>{{$sms_user['user_name']}}</span>
                </div>
            </div>
            <div class="list name">
                <label class="caption"><em class="f_redcolor">*</em>账号密码：</label>
                <div class="input-wrap">
                    <input type="password" class="W-input " id="user_pwd" name="user_pwd" value="" placeholder="密码长度为6-20个字符">
                </div>
            </div>
            <div class="list">
                <label class="caption"><em class="f_redcolor">*</em>产品名称：</label>
                <div class="form-group ">
                    <select class="stlectdefault form-control" style="width: auto;" id="product" name="product">
                        <option value="默认" @if($sms_user['product']=='默认')selected="selected" @endif>默认</option>
                        <option value="o2o" @if($sms_user['product']=='o2o')selected="selected" @endif>o2o</option>
                        <option value="p2p" @if($sms_user['product']=='p2p')selected="selected" @endif>p2p</option>
                        <option value="订餐" @if($sms_user['product']=='订餐')selected="selected" @endif>订餐</option>
                        <option value="众筹" @if($sms_user['product']=='众筹')selected="selected" @endif>众筹</option>
                        <option value="一元购" @if($sms_user['product']=='一元购')selected="selected" @endif>一元购</option>
                        <option value="其它" @if($sms_user['product']=='其它')selected="selected" @endif>其它</option>
                    </select>
                </div>
            </div>
            <div class="list ">
                <label class="caption"><em class="f_redcolor">*</em>账号签名：</label>
                <div class="input-wrap">
                    <input type="text" class="W-input " id="sign" onfocus="sign_del(this)" onblur="sign_add(this)" name="sign" value="{{$sms_user['sign']}}" placeholder="请输入账号签名">
                </div>
            </div>
            <div class="list save error">
                <a class="btn fit  defaul btn-red" id="button-edit"  role="button">修改</a>
            </div>
        </div>
        </form>

    </div>


</div>
</div>
@endsection
