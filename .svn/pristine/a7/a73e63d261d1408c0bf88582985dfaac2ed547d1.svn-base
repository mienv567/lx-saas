<?php
$_fw_MenuIndex = 0;
function getProductSalItem($product)
{
    if (empty($product) || empty($product->sale_items) || count($product->sale_items) <= 0) {
        return null;
    } else {
        return $product->sale_items[0];
    }
}
function displayProductItemId($product)
{
    $item = getProductSalItem($product);
    return empty($item) ? '' : $item->id;
}
function displayProductMarketPrice($product)
{
    $item = getProductSalItem($product);
    return empty($item) ? '' : $item->market_price;
}
function displayProductCurrentPrice($product)
{
    $item = getProductSalItem($product);
    return empty($item) ? '' : $item->current_price;
}
?>
@extends('layouts.base_system')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('res/css/system_detail.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('res/css/system_detail_extra.css')}}" />
@endsection

@section('scripts')
<script type="text/javascript">
function isSaleable()
{
	var itemId = $.trim($('#saleItemId').val());
	var price = $.trim($('#currentPrice').text());
    var saleable = ($.trim($('#saleable').val()) == '0') ? false : true;
    return (itemId && price && saleable);
}
function setBuyButtonStatus()
{
    if (isSaleable()) {
        $('#btnBuy').removeClass('btn-gray');
    } else {
        $('#btnBuy').addClass('btn-gray');
    }
}
function buyNow()
{
    if (isSaleable()) {
        var productId = $('#productId').val();
        var saleItemId = $('#saleItemId').val();
        document.location.href = "submit_order?id=" + productId + "&item_id=" + saleItemId;
    } else {
        //
    }
}
$(document).ready(function(){
    $(".chooseboxes .choosebox").bind("click",function(){
       $(this).siblings(".choosebox").removeClass("active");
       $(this).addClass("active");

       var itemId = $(this).attr("data-id");
       var price = $(this).attr("data-price");
       var salesprice = $(this).attr("data-salesprice");
       $('#saleItemId').val(itemId);
       $(this).parents(".detaillistbox").find(".price").text(price);
       $(this).parents(".detaillistbox").find(".salesprice").text(salesprice);
       setBuyButtonStatus();
    });
    setBuyButtonStatus();
});
</script>
@endsection

@section('content')
<div class="content">
<div class="tree-title">
<span><i class="iconfont">&#xe605;</i> 当前位置 > 云系统 > 应用市场 > <em>产品详细</em></span>
</div>

<div class="tree-content system_detail">
@if (empty($product))
    <div class="m-withe system_detailtit">该产品不存在或已下架！</div>
@else
<div class="m-withe system_detailtit">
    <div class="productimgbox"><img alt="" src="{{ $product->main_image or '../res/images/indexhead.png' }}"> </div>
    <div class="f_l system_detailinfo">
        <input id="productId" type="hidden" value="{{ $product->id or '' }}">
        <input id="saleItemId" type="hidden" value="{{ displayProductItemId($product) }}">
        <input id="saleable" type="hidden" value="{{ ($product->sale_visible && $product->sale_enabled) ? '1' : '0' }}">
        <h1>{{ $product->name or '' }}</h1>
        <h2>{!! $product->brief_introduce or '&nbsp;' !!}</h2>
        <div class="detaillistbox">
        <div class="detaillist">
            <label>价&nbsp;&nbsp;&nbsp;&nbsp;格：</label>
            <del class="price">{!! displayProductMarketPrice($product) !!}</del>元
        </div>
        <div class="detaillist">
            <label>促&nbsp;&nbsp;&nbsp;&nbsp;销：</label>
            <em id="currentPrice" class="salesprice">{!! displayProductCurrentPrice($product) !!}</em>元
        </div>
        <div class="detaillist">
            <label>套&nbsp;&nbsp;&nbsp;&nbsp;餐：</label>
            <div class="chooseboxes">
    @if (isset($product) && isset($product->sale_items))
        @foreach ($product->sale_items as $key => $value)
            <div class="choosebox {{  $key == 0 ? 'active' : ''}}" data-id="{{ $value->id }}" data-price="{{ $value->market_price }}" data-salesprice="{{ $value->current_price }}">{{ $value->name }}</div>
        @endforeach
    @endif
            <div>&nbsp;</div>
            <div class="blank0"></div>
            </div>
        </div>
        <div class="ljxgbtn">
            <a id="btnBuy" class="btn defaul fit btn-red" href="javascript:buyNow()" role="button">立即购买</a>
        </div>
        </div>
    </div>
    <div class="blank0"></div>
</div>
<div class="blank10"></div>
<div class="m-withe">
    <div class="system_tit">
    <ul class="tab">
    <li class="first active" rel="1"><a href="javascript:void(0);">服务详情</a></li>
    <li class="" rel="2"><a class="" href="javascript:void(0);">使用教程</a></li>
    <li class="" rel="3"><a class="" href="javascript:void(0);">订购记录</a></li>
    </ul>
    <div class="blank0"></div>
    </div>
    <div class="system_detail_content">
        <div class="tabcontent active" rel="1">
            
        </div><!-- rel=1 -->
        <div class="tabcontent" rel="2">
            
        </div><!-- rel=2 -->
        <div class="tabcontent" rel="3">
            
        </div><!-- rel=3 -->
       
    </div>
</div><!--m-withe end-->
@endif
</div><!--tree-content end-->
</div><!-- content end-->
@endsection
