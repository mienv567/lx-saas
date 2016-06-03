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
<script type="text/javascript" src="{{ url('res/js/market_detail.js') }}"></script>
@endsection

@section('content')
<div class="content">
<div class="tree-title">
<span><i class="iconfont">&#xe605;</i> 当前位置>{{ $_fw_AppTypeName or '' }}>应用市场><em>产品详细</em></span>
</div>

<div class="tree-content system_detail">
@if (empty($product))
    <div class="m-withe system_detailtit">该产品不存在或已下架！</div>
@else
<div class="m-withe system_detailtit">
    <div class="productimgbox"><img alt="" src="{{ empty($product->main_image) ? url('res/images/indexhead.png') : $product->main_image }}"> </div>
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
{!! $product->detail_introduce or '' !!}
        </div><!-- rel=1 -->
        <div class="tabcontent" rel="2">
{!! $product->use_course or '' !!}
        </div><!-- rel=2 -->
        <div class="tabcontent tab-orderrecord" rel="3">
            <div class="orderrecord">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>订单号</th>
                            <th class="textcenter">订购时间</th>
                            <th class="textright">订购用户</th>
                        </tr>
                    </thead>
                    <tbody>
    @foreach ($orders as $order)
                        <tr onclick="">
                            <td>{{ $order->order_no or '' }}</td>
                            <td class="textcenter">{{ $order->created_at or '' }}</td>
                            <td class="textright">{{ (empty($order->user) || empty($order->user->username)) ? '' : Utils::maskMiddleChar($order->user->username) }}</td>
                        </tr>
    @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- rel=3 -->
       
    </div>
</div><!--m-withe end-->
@endif
</div><!--tree-content end-->
</div><!-- content end-->
@endsection
