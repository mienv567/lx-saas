<?php $_fw_MenuIndex = 1; ?>
@extends('layouts.base_system')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('res/css/system_list.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('res/css/system_list_extra.css')}}" />
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    
});
</script>
@endsection

@section('content')
<div class="content">
<div class="tree-title">
<span><i class="iconfont">&#xe605;</i>当前位置>{{ $_fw_AppTypeName or '' }}><em>我的应用</em></span>
</div>

<div class="tree-content system_list">
<div class="m-withe">
    <div class="system_tit">
    <ul class="tab f_l">
    <li class="first active" rel="1"><a href="javascript:void(0);">全部</a></li>
    </ul>
    <div class="right">
        <!--
        <a class="btn btn-default defaul f_r" href="#" role="button">搜索</a>
        <div class="input-wrap f_r">
            <input type="text" class="W-input " id="mobile" name="mobile" value="" data-form-un="1460442869071.4133">
            <span class="holder-tip" style="display: inline;">请输入实例名称进行模糊查询</span>
        </div>
        -->
    </div>
    <div class="blank0"></div>
    </div>
    <div class="system_list_content">
@if (count($userProducts) <=0)
        <div class="tabcontent active" rel="1">
            <div class="listnone">
                您还未购买云系统产品，请<a class="a-link" href="{{ url($_fw_uriPrefix) }}">前往购买</a>
            </div>
            <div class="blank0"></div>
        </div>
@endif
        <div class="tabcontent active" rel="1">
            <ul>
@foreach ($userProducts as $userProduct)
<?php
    $buyInfo = empty($userProduct->buy_info) ? null : json_decode($userProduct->buy_info);
    $licenseDayCount = 0;
    if (!empty($buyInfo)) {
        $licenseDayCount = empty($buyInfo->license_day_count) ? 0 : intval($buyInfo->license_day_count);
    }
    $expireDate = ($licenseDayCount > 0) ? date('Y-m-d', strtotime('+'.$licenseDayCount.' day', strtotime($userProduct->created_at))) : '永久';
?>
                <li>
    @if (empty($userProduct->sale_item_name))
                    <h1>{{ $userProduct->product_name or '' }}</h1>
    @else
                    <h1>{{ $userProduct->product_name or '' }} - {{ $userProduct->sale_item_name or '' }}</h1>
    @endif
                    <div class="imgbox">
                    <img alt="" src="{{ empty($userProduct->product->main_image) ? url('res/images/indexhead.png') : $userProduct->product->main_image }}""> 
                    </div>
                    <div class="listinfo">{{ $userProduct->product->brief_introduce or '' }}</div>
                    <div class="listinfo2">
                        <span class="expire">有效期至：{{ $expireDate }}</span>
                        <a class="btn line btn-red f_r" href="mydetail?id={{ $userProduct->id }}" role="button">设置管理</a>
                        <div class="blank0"></div>
                    </div>
                </li>
@endforeach
            </ul>
            <div class="blank0"></div>
        </div>
    </div>
</div><!--m-withe end-->
</div><!--tree-content end-->
</div><!-- content end-->
@endsection
