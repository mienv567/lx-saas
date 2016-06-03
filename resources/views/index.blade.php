<?php
$_fw_HtmlTitle = '首页';

function displayProductPrice($product)
{
    if (empty($product) || empty($product->sale_items) || count($product->sale_items) <= 0) {
        return '';
    } else {
        $price = PHP_INT_MAX;
        foreach ($product->sale_items as $item) {
            $price = min($price, $item->current_price);
        }
        return '<b>'.$price.'</b> / 套';
    }
}
?>

@extends('layouts.base')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('res/css/basicdata.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('res/css/phonebind.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('res/css/basicdata_extra.css')}}" />
<style>
    .list .tip {
        position: initial;
        top: 0;
        right: -260px;
        width: 250px;
        text-align: left;
        line-height: 37px;
        font-weight: normal;
        color: #e47470;
    }
    .basetit .headimg {
    	background-position: center center;
        background-size: cover;
    }
</style>
@endsection

@section('scripts')
<script type='text/javascript' src='{{asset('res/js/send-sms2.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/rephone.js')}}' charset='utf-8'></script>

<script>
var url = "user/showAppCert"

function hideUserAppCert()
{
    $('#userAppCert').hide();
}

function hidemobileAppCert()
{
    $('#mobileAppCert').hide();
}

function toggleUserAppSecretDisplay(tp){
    if(tp<2)
    { //显示key
        var mobile_appkey = $("input[name=lo_appkey]").val();
        if(mobile_appkey==1){
            var app_secret =  $("input[name=app_sec]").val();
            var btn = $('#viewUserCertBtn');
            var obj = $('#userAppCert');
            var x = btn.offset().left;
            var y = btn.offset().top;
            var w = btn.outerWidth();
            var h = btn.outerHeight();
            obj.show();
            var ow = obj.outerWidth();
            obj.css('left', (x - ow + w) + 'px');
            obj.css('top', (y + h + 10) + 'px');
        }else{
            var btn = $('#viewUserCertBtn');
            var obj = $('#mobileAppCert');
            var x = btn.offset().left;
            var y = btn.offset().top;
            var w = btn.outerWidth();
            var h = btn.outerHeight();
            obj.show();
            var ow = obj.outerWidth();
            obj.css('left', (x - ow + w) + 'px');
            obj.css('top', (y + h + 10) + 'px');
            $('#button-res').hide();
            $('#button-mobile_key').show();
        }
    }else{ //重置key
        var btn = $('#viewUserCertBtn');
        var obj = $('#mobileAppCert');
        var x = btn.offset().left;
        var y = btn.offset().top;
        var w = btn.outerWidth();
        var h = btn.outerHeight();
        obj.show();
        var ow = obj.outerWidth();
        obj.css('left', (x - ow + w) + 'px');
        obj.css('top', (y + h + 10) + 'px');
        $('#button-res').show();
        $('#button-mobile_key').hide();
    }
}
</script>
@endsection


@section('content')
<div class="content">
    <div class="tree-title">
        <span><i class="iconfont">&#xe605;</i>当前位置>首页><em>基本资料</em></span>
    </div>
    <div class="tree-content">
        <div class="m-withe basetit">
            <div class="left">
                <div class="headimg" style="background-image: url( {{ url(($user->photo) ? $user->photo : asset('res/images/head_deafaul.png')) }} )">
                    <!-- <img src="@if($user->photo){{$user->photo}}@else {{asset('res/images/head_deafaul.png')}}@endif"> -->
                </div>
                <div class="headcontent">
                    <h1>{{ empty($user) ? '' : (empty($user->nickname) ? $user->username : $user->nickname) }}</h1>
@if (empty($user) || empty($user->company_name))
                    <div class="list">主体信息：{{ $user->company_name or '' }} <a class="a-link" href="{{ url('user/account_setting') }}">[完善信息]</a></div>
@else
                    <div class="list">主体信息：{{ $user->company_name or '' }}</div>
@endif
                    <div class="list">
                        <!-- 账户ID：1543651231685465123135156 -->
                        <span class="pd30"></span>
                        APP证书：{{$user->app_id}}
                    </div>
                    <div class="list">
                        APP秘钥：<a id="viewUserCertBtn" class="a-link" href="javascript:toggleUserAppSecretDisplay(1)">查看秘钥</a><a id="userAppSecretShowBtn" class="a-link"  href="javascript:toggleUserAppSecretDisplay(2);">重置秘钥</a><!-- <i class="iconfont look">&#xe606;</i> -->
                    </div>
                    <div class="list">
                        <i class="iconfont sj">&#xe608;</i>{{ Utils::maskPhone($user->mobile) }}<a class="a-link" href="{{ url('user/phonebind_one') }}">修改手机</a>
                        <!-- 
                        <i class="iconfont sj">&#xe60a;</i>{{ Utils::maskEmail($user->email) }}<a class="a-link" href="javascript:void(0)">修改</a>
                        -->
                    </div>
                    <div class="list">
                        <i class="iconfont sj">&#xe60a;</i>
                        <!-- 已绑定邮箱 -->
                        @if($user->mobile)
                       <a class="a-link" href="{{url('user/email_one')}}">修改邮箱</a>
                        @else
                        <!-- 未绑定邮箱 -->
                        <a class="a-link" href="javascript:void(0)">绑定邮箱</a>
                        @endif
                    </div>

                    <div class="blank0"></div>
                </div>
                <div class="blank0"></div>
            </div>
            <div class="right">
                <div class="rcontent">
                    <h1>余额：</h1>
                    <h2>{{ empty($user) ? '0.00' : number_format($user->money, 2) }} <a class="a-link" href="{{ url('user/finance_manage#recharge') }}">明细</a></h2>
                    <div class="btnrecharge"><a class="btn  btn-red" href="{{ url('user/financial_recharge') }}">我要充值</a></div>
                </div>
            </div>
            <div class="blank0"></div>
        </div>
        <div class="newswrap">
            <div class=" left">
                <div class="m-withe">
                    <table class="table table-hover">
                    <thead>
                        <tr>
                          <th>站内消息<span>{{ $messageCount or '' }}</span></th>
@if (empty($messages) || count($messages)<5)
                            <th class="textright"> &nbsp;</th>
@else
                          <th class="textright"><a href="{{ url('user/message_list') }}">更多</a></th>
@endif
                        </tr>
                    </thead>
                    <tbody>
@if (empty($messages) || count($messages) <= 0)
                       <!--  <tr onclick="">
                          <td colspan="2" class="nomessage">暂无消息！</td>
                        </tr> -->
@else
  <?php $blankRowStart = 0;?>
  @foreach ($messages as $message)
    <?php $blankRowStart++;?>
                        <tr onclick="javascript:window.location.href='{{ url('user/message_detail?id='.$message->id) }}'">
                          <td>{{ $message->title or '' }}</td>
                          <td class="small">{{ date('Y-m-d', strtotime($message->created_at)) }} &nbsp; {{ date('H:i:s', strtotime($message->created_at)) }}</td>
                        </tr>
  @endforeach
  @for ($i = $blankRowStart; $i < 5; $i++)
                  <!--       <tr onclick="">
                          <td>&nbsp;</td>
                          <td class="small">&nbsp;</td>
                        </tr> -->
  @endfor
  @if ($i < 5)
                        <tr onclick="">
                          <td>&nbsp;</td>
                          <td class="small">&nbsp;</td>
                        </tr>
    @endif
@endif
                    </tbody>
                    </table>
                    @if (empty($messages) || count($messages) <= 0)
                    <div class="nonews"><i class="iconfont">&#xe625;</i>暂时没有消息哦</div>
                   @endif
                    
                </div>
            </div>
            <div class="right">
                <div class="m-withe">
                    <table class="table table-hover">
                    <thead>
                        <tr>
                          <th>公告</th>
@if (empty($bulletins) || count($bulletins) <= 5)
                          <th class="textright">&nbsp;</th>
@else
                          <th class="textright"><a href="{{ url('user/bulletin_list') }}">更多</a></th>
@endif
                        </tr>
                    </thead>
                    <tbody>
@if (empty($bulletins) || count($bulletins) <= 0)
                     <!--    <tr onclick="">
                          <td colspan="2" class="nomessage">暂无公告！</td>
                        </tr> -->
@else
  <?php $blankRowStart = 0;?>
  @foreach ($bulletins as $bulletin)
    <?php $blankRowStart++;?>
                        <tr onclick="javascript:window.location.href='{{ url('user/bulletin_detail?id='.$bulletin->id) }}'">
                          <td>{{ $bulletin->title or '' }}</td>
                          <td class="small">{{ date('Y-m-d', strtotime($bulletin->created_at)) }} &nbsp; {{ date('H:i:s', strtotime($bulletin->created_at)) }}</td>
                        </tr>
  @endforeach
  @for ($i = $blankRowStart; $i < 5; $i++)
  @endfor
  @if ($i < 5)
                        <tr onclick="">
                          <td>&nbsp;</td>
                          <td class="small">&nbsp;</td>
                        </tr>
    @endif
@endif
                    </tbody>
                    </table>
                    @if (empty($bulletins) || count($bulletins) <= 0)
                    <div class="nonews"><i class="iconfont">&#xe625;</i>暂时没有消息哦</div>
                   @endif
                </div>
            </div>
            <div class="blank0"></div>
        </div>
        <div class="blank15"></div>
        <div class="m-withe">
            <div class="system_tit">
                <ul class="f_l"><!-- <ul class="tab f_l"> -->
                    <li class="active"><a href="cloud_system">热门应用推荐</a></li>
                </ul>
                <div class="blank0"></div>
             </div><!-- system_tit -->
            <div class="system_list_content">
                <ul>
                    @foreach ($appsys as $product)
                    <li>
                        <h1>{{ $product->name or '' }}<img src="{{asset('res/images/icon_new.png')}}"></h1>
                        <div class="imgbox">
                        <img alt="" src="{{ empty($product->main_image) ? url('res/images/indexhead.png') : $product->main_image }}"> 
                        </div>
                        <div class="listinfo">{{ $product->brief_introduce or '' }}</div>
                        <div class="listinfo2">
                            <div class="f_l f_redcolor">{!! displayProductPrice($product) !!}</div>
                            @if ($product->status == 1)
                                @if (!empty($product->detail_link) && trim($product->detail_link) != '')
                                    <a class="btn line btn-red f_r" href="{{ trim($product->detail_link) }}" role="button" target="_blank">查看详情</a>
                                @endif
                            @else
                            <a class="btn line btn-red f_r" href="{{ $_fw_uriPrefix}}/detail?id={{ $product->id }}" role="button">查看详情</a>
                            @endif
                            <div class="blank0"></div>
                        </div>
                    </li>
                    @endforeach
                    <li>
                        <h1>{{ $product->name or '' }}<img src="{{asset('res/images/icon_new.png')}}"></h1>
                        <div class="imgbox">
                        <img alt="" src="{{ empty($product->main_image) ? url('res/images/indexhead.png') : $product->main_image }}"> 
                        </div>
                        <div class="listinfo">
                        新一代涨粉利器！你发红包，我来摇，现金礼券好友来相助。规定时间内好友助力成功才能拿红包哦，分分钟考验人品有木有！
                        新一代涨粉利器！你发红包，我来摇，现金礼券好友来相助。规定时间内好友助力成功才能拿红包哦，分分钟考验人品有木有！</div>
                        <div class="listinfo2">
                            <div class="f_l f_redcolor">0.01元/套</div>
                            <a class="btn line btn-red f_r" href="{{ $_fw_uriPrefix}}/detail?id={{ $product->id }}" role="button">查看详情</a>
                            <div class="blank0"></div>
                        </div>
                    </li>
                    <li>
                        <h1>自然红包<img src="{{asset('res/images/icon_new.png')}}"></h1>
                        <div class="imgbox">
                        <img alt="" src="{{ empty($product->main_image) ? url('res/images/indexhead.png') : $product->main_image }}"> 
                        </div>
                        <div class="listinfo">
                        新一代涨粉利器！你发红包，我来摇，现金礼券好友来相助。规定时间内好友助力成功才能拿红包哦，分分钟考验人品有木有！
                        新一代涨粉利器！你发红包，我来摇，现金礼券好友来相助。规定时间内好友助力成功才能拿红包哦，分分钟考验人品有木有！</div>
                        <div class="listinfo2">
                            <div class="f_l f_redcolor">0.01元/套</div>
                            <a class="btn line btn-red f_r" href="{{ $_fw_uriPrefix}}/detail?id={{ $product->id }}" role="button">查看详情</a>
                            <div class="blank0"></div>
                        </div>
                    </li>
                    <li>
                        <h1>自然红包<img src="{{asset('res/images/icon_new.png')}}"></h1>
                        <div class="imgbox">
                        <img alt="" src="{{ empty($product->main_image) ? url('res/images/indexhead.png') : $product->main_image }}"> 
                        </div>
                        <div class="listinfo">
                        新一代涨粉利器！你发红包，我来摇，现金礼券好友来相助。规定时间内好友助力成功才能拿红包哦，分分钟考验人品有木有！
                        新一代涨粉利器！你发红包，我来摇，现金礼券好友来相助。规定时间内好友助力成功才能拿红包哦，分分钟考验人品有木有！</div>
                        <div class="listinfo2">
                            <div class="f_l f_redcolor">0.01元/套</div>
                            <a class="btn line btn-red f_r" href="{{ $_fw_uriPrefix}}/detail?id={{ $product->id }}" role="button">查看详情</a>
                            <div class="blank0"></div>
                        </div>
                    </li>
                </ul>
                <div class="blank0"></div>
            </div><!-- system_list_content -->
        </div><!-- m-withe -->
    </div><!-- tree-content -->
</div><!-- content -->
<div id="userAppCert" style="display: none;">
    <h1>APP秘钥</h1><span class="close" onclick="javascript:hideUserAppCert();"></span>
    <ul>
        <input type="hidden" name="app_sec" @if(session('lo_appkey'))value="{{$user->app_secret}}"@endif>
        <input type="hidden"  id="lo_appkey" name="lo_appkey" @if(session('lo_appkey'))value="1"@endif>
        <li>
            <label>App Secret: </label>
            <span id="userAppSecretMark">@if(session('lo_appkey')){{$user->app_secret}}@endif</span>
        </li>
    </ul>
</div>


<div id="mobileAppCert" style="display: none;">
    <h1>手机验证</h1><span class="close" onclick="javascript:hidemobileAppCert();"></span>
    <ul>
        <li>
            <div class="list">
                <div class="list">
                    <i class="iconfont sj">&#xe608;</i>{{ Utils::maskPhone($user->mobile) }}
                </div>
            </div>
        </li>
        <li>
            <div class="list sjyzm" id="verify">
                <input type="hidden"  id="mobile" name="mobile" value="{{$user->mobile}}">
                <div class="input-wrap yzm">
                    <input type="text" class="W-input " id="verifyCode" name="verifyCode" value="">
                    <span class="holder-tip" style="display: block;"></span>
                    <div style="clear: both;" ></div>
                </div>
                <button id="sendVerifySmsButton" class="btn defaul btn-default">获取手机验证码</button>
            </div>
        </li>
        <li>
            <div class="list save">
                <a class="btn fit  defaul btn-red" id="button-mobile_key" role="button">下一步</a>
                <a class="btn fit  defaul btn-red" id="button-res" role="button">下一步</a>
            </div>
        </li>
    </ul>
</div>
@endsection

