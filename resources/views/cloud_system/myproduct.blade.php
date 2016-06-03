<?php $_fw_MenuIndex = 1; ?>
@extends('layouts.base_system')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('res/css/system_list.css')}}" />
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
<span><i class="iconfont">&#xe605;</i>当前位置 > 云系统 > <em>我的应用</em></span>
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
        <div class="tabcontent active" rel="1">
            <ul>
@foreach ($userProducts as $userProduct)
                <li>
                    <h1>{{ $userProduct->product_name or '' }} - {{ $userProduct->sale_item_name or '' }}</h1>
                    <div class="imgbox">
                    <img alt="" src="{{ $userProduct->product->main_image or url('res/images/indexhead.png') }}""> 
                    </div>
                    <div class="listinfo">{{ $userProduct->product->brief_introduce or '' }}</div>
                    <div class="listinfo2">
                        <a class="btn line btn-red f_r" href="myproduct_set?id={{ $userProduct->id }}" role="button">设置管理</a>
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
