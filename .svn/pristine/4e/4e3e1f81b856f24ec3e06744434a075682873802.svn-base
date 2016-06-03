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

function loadSmsUser(page){
    $("#page").val(page);
    $('.form_user').submit();
}

$("#go-page").bind('click',function() {
    $("#page").val($("#user-page").val());
    $('.form_user').submit();
});

$("#sms_recharge").bind('click',function(){
  var recharge_number = $("input[name='recharge_number']").val();
  var _token = $("input[name='_token']").val();
  $.ajax({
      url: '{{url("cloud_service/sms_recharge/recharge")}}',
      dataType: "json",
      data:'recharge_number='+recharge_number+'&_token='+_token,
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
});
</script>
@endsection

@section('content')
<div class="content">
<div class="tree-title">
<span><i class="iconfont">&#xe605;</i>当前位置>云服务><em>短信账号</em></span>
</div>
<div class="tree-content financial_consumer">
    <div class="m-withe financialtit">
        <div class="f_l"><span></span> </div>
        <div class="f_l"><em></em></div>
        <div class="f_l flowbox">
          <a class="btn line btn-red f_l tgflow" href="{{route('cloud_service.sms_user.actor',['type'=>'add'])}}" role="button">添加账号</a>
          <a class="btn line btn-red f_l tgflow" href="{{route('cloud_service.sms_user.actor',['type'=>'bind'])}}" role="button">绑定账号</a>
          <input name="_token" type="hidden" value="{{csrf_token()}}"/>
        </div>
        <div class="blank0"></div>
    </div>

    <div class="financialtab">
        <ul class="tab">
            <li class="first active" rel="1"><a href="javascript:void(0);">充值明细</a></li>
        </ul>
        <div class="tabcontent active" rel="1">
        <div class="m-withe">
            <form class="form_user" method="get" action="{{url('cloud_service/sms_user')}}">
            <input type="hidden" name="page" id="page" value="{{$page}}"/>
            <div class="financialist1">
                <div class="list f_l timelist">
                <span class="f_l lh37">时间<i class="iconfont f_garycolor">&#xe606;</i>：</span>
                <div class="u-datepicker  f_l">
                    <div class="input-wrap">
                        <input type="text" name="user_start_time" class="W-input " id="activitystart1" value="@if(isset($all['user_start_time'])){{$all['user_start_time']}}@endif" placeholder="开始时间">
                        <span class="holder-tip"></span>
                    </div>
                </div>
                <span class="f_l lh37 zhi">&nbsp;至&nbsp;</span>
                <div class="u-datepicker f_l">
                    <div class="input-wrap">
                        <input type="text" name="user_end_time" class="W-input " id="activityend1" value="@if(isset($all['user_end_time'])){{$all['user_end_time']}}@endif" placeholder="结束时间">
                        <span class="holder-tip"></span>
                    </div>
                </div>
                </div>
                <a class="btn defaul  btn-default f_l" onclick="loadSmsUser(1)" role="button">查询</a>
                <div class="blank0"></div>
            </div>
            </form>
        </div>
        <div class="financialist3">
            <table class="table table-hover">
            <thead>
                <tr>
                    <th>账户名称</th>
                    <th>产品名称</th>
                    <th>短信数量</th>
                    <th>创建时间</th>
                    <th  class="textright">操作</th>
                </tr>
            </thead>
            <tbody>
            @if(sizeof($sms_users))
            @foreach ($sms_users as $user)
                <tr onclick="">
                    <td>{{$user['user_name']}}</td>
                    <td>{{$user['product']}}</td>
                    <td>{{$user['sms_number']}}</td>
                    <td>{{date('Y-m-d H:i:s',$user['create_time'])}}</td>
                    <td  class="textright"><a class="a-link" href="{{route('cloud_service.sms_user.edit',['uid'=>$user['id']])}}">编辑</a><span class="line1"></span><a class="a-link" href="{{route('cloud_service.sms_recharge.index',['uid'=>$user['id']])}}">明细</a></td>
                </tr>
            @endforeach
            @endif
            </tbody>
            </table>
        </div>
        <div class="financialist4">
            @if(sizeof($render))
              <a class="btn defaul  btn-default f_r" id="go-page" role="button">GO</a>
              <div class="input-wrap f_r">
                  <input type="text" class="W-input " id="user-page" value="" data-form-un="1460442869071.4133">
                  <span class="holder-tip" style="display: inline;"></span>
              </div>
              <ul class="pagination f_r">
                <li @if($page==1)class="disabled" @endif>
                  <a @if($page!=1) onclick="loadSmsUser({{$page-1}})" @endif aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>
                @foreach ($render as $r)
                <li class="  @if($r==$page) active @endif @if($r=='...') disabled @endif"><a @if($r!='...')onclick="loadSmsUser({{$r}})" @endif>{{$r}}</a></li>
                @endforeach
                <li @if($page==$render[sizeof($render)-1])class="disabled" @endif>
                  <a @if($page!=$render[sizeof($render)-1]) onclick="loadSmsUser({{$page+1}})"@endif aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
              </ul>
            @endif
          <span class="f_garycolor f_r">共有{{$totalCount}}条，每页显示：{{$page_size}}条</span>
          <div class="blank0"></div>
        </div>
        </div><!-- tabcontent end -->
        </div><!-- tabcontent end -->
    </div>

</div>


</div>
@endsection
