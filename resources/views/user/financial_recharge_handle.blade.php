<?php $menuIndex = empty($_fw_MenuIndex) ? 0 : intval($_fw_MenuIndex)?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>方维云平台</title>
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
<style>
#hint{width:100%;padding-top:30px;text-align:center;font-size:18px;color:#f37108}
</style>
</head>
<body>
    <div style="display:none">{!! $code or '' !!}</div>
    <div id="hint">正在提交支付中...</div>
<script type='text/javascript' src='{{asset('res/js/jquery-1.8.3.min.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/public/fanwe_ui.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/public.js')}}' charset='utf-8'></script>
<script type='text/javascript'>
$(function(){
    if (window.opener) {
       $("#recharge-payment", window.opener.document).val("{{ $payment or '' }}");
    }
    $('#_PayForm').submit();
});
</script>
</body>
</html>
