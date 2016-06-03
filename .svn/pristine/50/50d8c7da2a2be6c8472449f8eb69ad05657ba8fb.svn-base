<?php $_fw_MenuIndex = 1; ?>
@extends('layouts.base_system')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ url('res/css/system_detail.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('res/css/system_detail_extra.css') }}" />
@endsection

@section('scripts')
<script type="text/javascript" src="{{ url('res/js/my_detail.js') }}"></script>
@endsection

@section('content')
<div class="content">
<div class="tree-title">
<span><i class="iconfont">&#xe605;</i>当前位置>{{ $_fw_AppTypeName or '' }}><em>产品设置</em></span>
</div>

<div class="tree-content system_detail">
@if (empty($userProduct))
<div class="m-withe system_detailtit">
    该应用产品不存在或还未购买！
</div>
@else
<input id="userProductId" type="hidden" value="{{ $userProduct->id or "" }}" />
<div class="m-withe system_detailtit">
    <div class="productimgbox"><img alt="" src="{{ empty($userProduct->product->main_image) ? url('res/images/indexhead.png') : $userProduct->product->main_image }}"> </div>
    <div class="f_l system_detailinfo">
    @if (empty($userProduct->sale_item_name))
        <h1>{{ $userProduct->product_name or '' }}</h1>
    @else
        <h1>{{ $userProduct->product_name or '' }} - {{ $userProduct->sale_item_name or '' }}</h1>
    @endif
        <h2>{{ $userProduct->product->brief_introduce or '' }}</h2>
        <div class="detaillistbox">
        <div class="detaillist">
            <label>授权信息：</label>
<?php
$buyInfo = empty($userProduct->buy_info) ? null : json_decode($userProduct->buy_info);
$licenseDomainCount = 0;
$licenseDayCount = 0;
$licenseFuncPackage = '';
if (!empty($buyInfo)) {
    $licenseDomainCount = empty($buyInfo->license_domain_count) ? 0 : intval($buyInfo->license_domain_count);
    $licenseDayCount = empty($buyInfo->license_day_count) ? 0 : intval($buyInfo->license_day_count);
    $licenseFuncPackage = empty($buyInfo->license_func_package) ? '' : $buyInfo->license_func_package;
}
?>
            <ul>
    @if ($licenseDomainCount > 0)
               <li class="domains">授权<strong>{{ $licenseDomainCount or '' }}</strong>个域名</li>
    @else
               <li class="domains">不限域名数</li>
    @endif
               <input id="licenseDomainCount" type="hidden" value="{{ $licenseDomainCount or '' }}" />
               <li class="split">|</li>
    @if ($licenseDayCount > 0)
               <li class="months">授权<strong>{{ $licenseDayCount or '' }}</strong>天</li>
    @else
               <li class="months">不限授权期限</li>
    @endif
    @if (!empty($licenseFuncPackage))
               <li class="split">|</li>
               <li class="package">功能套餐号：{{ $licenseFuncPackage or '' }}</li>
    @endif
            </ul>
        </div>
        <div class="detaillist">
            <label>购买时间：</label>
            {{ date('Y-m-d H:i:s', strtotime($userProduct->created_at)) }}
        </div>
        <div class="detaillist">
            <label>到期时间：</label>
    @if ($licenseDayCount > 0)
            {{ date('Y-m-d H:i:s', strtotime('+'.$licenseDayCount.' day', strtotime($userProduct->created_at))) }}
    @else
            永不过期
    @endif
        </div>
        <div class="detaillist">
    @if (!isset($userProduct->license) || empty($userProduct->license))
        @if ($userProduct->product_type == 2)
            <label>授权文件：</label>
            <span id="licensefile"><span class="nolicense">授权文件未生成 <a class="a-link" href="javascript:createCloudPlatformLicense()">[生成授权]</a></span></span>
        @else
            <label>授权文件：</label>
            <span id="licensefile"><span class="nolicense">授权文件未生成，请通过“产品设置”来生成</span></span>
        @endif
    @else
        @if ($userProduct->product_type == 2)
            <!--
            <label>授权文件：</label>
            <span id="licensefile"><a class="a-link" href="javascript:createCloudPlatformLicense()">更新授权</a></span></span>
            -->
        @else
            <label>授权文件：</label>
            <span id="licensefile"><a class="a-link" href="down_license?id={{ $userProduct->license->id or '' }}" role="button" target="_blank">下载</a></span>
        @endif
    @endif
        </div>
        </div>
    </div>
    <div class="blank0"></div>
</div>
<div class="blank10"></div>
<div class="m-withe">
    @yield('detail_info')
</div><!--m-withe end-->
@endif
</div><!--tree-content end-->
</div><!-- content end-->
@endsection
