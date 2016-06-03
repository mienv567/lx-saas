<?php
$menuIndex = empty($_fw_MenuIndex) ? 0 : intval($_fw_MenuIndex);
$htmlTitle = empty($_fw_HtmlTitle) ? '' : $_fw_HtmlTitle;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ ($htmlTitle == '') ? '' : $htmlTitle.' - ' }}方维云平台 - 互联网创新模式与技术服务解决方案提供商</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=0,minimum-scale=0.5">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link href="{{asset('res/public/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('res/public/animation.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('res/public/fanwe_ui.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('res/css/reset.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('res/css/public.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('res/css/frame.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('res/css/public_extra.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('res/css/frame_extra.css')}}" />
    @yield('styles')
    <script type="text/javascript">
        var FW = {
            "DOMAIN":"{{config('app.url')}}"
        }
    </script>
	</head>
<body>
<div class="layout-header">
<div class="logo f_l">
	<div class="c-left-nav"><i class="iconfont"></i></div>
	<a href="http://yun.fanwe.com/"><img src="{{asset('res/images/logo.png')}}"></a>
</div>
<div class="nav f_l">
	<a class="active" href="{{ url('') }}">首页</a>
	<a class="" href="{{ url('cloud_service/') }}">云服务</a>
	<a class="" href="{{ url('cloud_system/') }}">云系统</a>
	<a class="" href="{{ url('cloud_platform/') }}">云平台</a>
</div>

<div class="navright f_r">
	<div class="navrightlist">
	    {{Auth::user()->username}}<i class="iconfont">&#xe604;</i>
	    <div class="hidenav active">
	        <a href="{{ url('/logout') }}">退出</a>
	    </div>
	</div>
</div>
<div class="blank0"></div>
</div>

<div class="layout-main">
	<div class="layout-left">
		<div class="nav">
			<div class="navlist">
				<a class="{{ ($menuIndex == 0) ? 'active' : '' }}" href="{{ url('/') }}">
				<i class="iconfont left basicdata"><b class="bg-success"></b></i>
				<span>基本资料</span>
				<i class="iconfont right"></i>
				<div class="blank0"></div>
				</a>
			</div>
			<div class="navlist">
				<a class="{{ ($menuIndex == 1) ? 'active' : '' }}" href="{{ url('user/finance_manage') }}">
				<i class="iconfont left financialmanage"><b class="bg-info"></b></i>
				<span>财务管理</span>
				<i class="iconfont right"></i>
				<div class="blank0"></div>
				</a>
			</div>
			<div class="navlist">
				<a class="{{ ($menuIndex == 2) ? 'active' : '' }}" href="{{ url('user/account_setting') }}">
				<i class="iconfont left accountset"><b class="bg-danger"></b></i>
				<span>账号设置</span>
				<i class="iconfont right"></i>
				<div class="blank0"></div>
				</a>
			</div>
		</div>
	</div>
	<div class="layout-right">
	@yield('content')
	</div>

</div>

<script type='text/javascript' src='{{asset('res/js/jquery-1.8.3.min.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/public/fanwe_ui.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/common.js')}}' charset='utf-8'></script>
@yield('scripts')

</body>
</html>
