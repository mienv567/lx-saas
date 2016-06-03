<?php
$_fw_MenuIndex = 0;
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
@extends('layouts.base_system')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('res/css/system_list.css')}}" />
@endsection

@section('scripts')
<script type="text/javascript">
function search()
{
    var keyword = $.trim($('#keyword').val());
    document.location.href = '?keyword=' + keyword;
}
$(document).ready(function(){
    $('#keyword').keyup(function(ev) {
        if (ev.keyCode==13) {
            search();
        }
    });
});
</script>
@endsection

@section('content')
<div class="content">
<div class="tree-title">
<span><i class="iconfont">&#xe605;</i> 当前位置 > 云系统 > <em>应用市场</em></span>
</div>

<div class="tree-content system_list">
<div class="m-withe">
    <div class="system_tit">
    <ul class="tab f_l">
    <li class="first active" rel="1"><a href="javascript:void(0);">全部</a></li>
    </ul>
    <div class="right">
        <a id="btnSearch" class="btn btn-default defaul f_r" href="javascript:search();" role="button">搜索</a>
        <div class="input-wrap f_r">
            <input type="text" class="W-input " id="keyword" name="keyword" value="{{ Request::input('keyword') }}" data-form-un="1460442869071.4133">
            <span class="holder-tip" style="display: inline;">请输入产品名称进行模糊查询</span>
        </div>
    </div>
    <div class="blank0"></div>
    </div>
    <div class="system_list_content">
        <div class="tabcontent active" rel="1">
            <ul>
@foreach ($products as $product)
                <li>
                    <h1>{{ $product->name or '' }}</h1>
                    <div class="imgbox">
                    <img alt="" src="{{ $product->main_image or url('res/images/indexhead.png') }}"> 
                    </div>
                    <div class="listinfo">{{ $product->brief_introduce or '' }}</div>
                    <div class="listinfo2">
                        <div class="f_l f_redcolor">{!! displayProductPrice($product) !!}</div>
                        <a class="btn line btn-red f_r" href="cloud_system/product_detail?id={{ $product->id }}" role="button">查看详细</a>
                        <div class="blank0"></div>
                    </div>
                </li>
@endforeach
            </ul>
            <div class="blank0"></div>
        </div><!-- rel=1 -->
    </div>
</div><!--m-withe end-->
</div><!--tree-content end-->
</div><!-- content end-->
@endsection
