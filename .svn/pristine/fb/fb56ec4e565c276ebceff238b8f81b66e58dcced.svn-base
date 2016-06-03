<?php $_fw_HTMLTitle = '首页'; $_fw_ContextPath = ''; ?>
@extends('layouts.base')

@section('head_css')
<link rel="stylesheet/less" type="text/css" href="res/css/frame.less">
@endsection

@section('head_js')
@endsection


@section('content')
<div class="layout-header">
<div class="logo f_l">
	<div class="c-left-nav"><i class="iconfont"></i></div>
	<a href="javascript:void(0)"><img src="res/images/logo.png"></a>
</div>
<div class="nav f_l">
	<a class=""  href="{{ url('') }}">首页</a>
	<a class="active"  href="javascript:void(0)" >云服务</a>
	<a class="" href="javascript:void(0)" data-href="cloud_system">云系统</a>
	<a class="" href="javascript:void(0)" data-href="cloud_platform">云平台</a>
</div>

<div class="navright f_r">
	<div class="navrightlist">1595***8013<i class="iconfont">&#xe604;</i></div>
</div>
<div class="blank0"></div>
</div>
<div class="layout-main">
	<div class="layout-left">
		<div class="nav">
			<div class="navlist">
				<a class="active" href="javascript:void(0)" data-href="cloud_service/weixin_info">
				<i class="iconfont left basicdata"><b class="bg-success"></b></i>
				<span>微信授权</span>
				<i class="iconfont right"></i>
				<div class="blank0"></div>
				</a>
			</div>
			<div class="navlist">
                <a href="javascript:void(0)" data-href="cloud_service/flow_red">
                <i class="iconfont left basicdata"><b class="bg-success"></b></i>
                <span>流量红包</span>
                <i class="iconfont right"></i>
                <div class="blank0"></div>
                </a>
            </div>

		</div>
	</div>
	<div class="layout-right">
	<iframe class="mainiframe" src="cloud_service/weixin_info"></iframe>
	</div>

</div>

<script type="text/javascript">
$(document).ready(function(){
	//顶部导航栏
	$(".layout-header .nav>a").bind('click',function(){
    	$(".layout-header .nav>a").removeClass("active");
    	$(this).addClass("active");
    	var link=$(this).attr("data-href");
    	$(".mainiframe").attr("src",link);
    });
	//侧边导航栏
	$(".navlist>a").bind('click',function(){
    	$(".navlist>a").removeClass("active");
    	$(this).addClass("active");
    	var link=$(this).attr("data-href");
    	$(".mainiframe").attr("src",link);
    });
	//侧边导航栏展开关闭
	$(".c-left-nav").bind('click',function(){
    	$(".layout-main").toggleClass("close");
    });
});
$(document).ready(function(){
});
</script>

@endsection