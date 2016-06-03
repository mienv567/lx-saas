<?php
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
    <script type="text/javascript">
        var FW = {
            "DOMAIN":"{{config('app.url')}}"
        }
    </script>
    @yield('styles')
	</head>
<body>
<div class="blank85"></div>
<div class="header">
  <div class="wrap">
    <div class="logo">
      <a href="http://yun.fanwe.com/"><img src="{{asset('res/images/loginlogo.png')}}"></a>
    </div>
    <!-- <span class="left">欢迎登录</span>
    <a class="right" href="/">返回首页</a> -->
    <div class="blank0"></div>
  </div>
</div>

@yield('content')

<div class="footer">
  互联网创新模式与技术服务解决方案提供商<br>
  copyright©2006-2016，福建方维信息科技有限公司版权所有沪IPC备06024200号，闽ICP备10206706号-7

</div>

<script type='text/javascript' src='{{asset('res/js/jquery-1.8.3.min.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/public/fanwe_ui.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/public.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/common.js')}}' charset='utf-8'></script>
@yield('scripts')

</body>
</html>