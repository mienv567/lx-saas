<?php
$_fw_MenuIndex = 0;
?>
@extends('layouts.base_system')

@section('styles')
<style type="text/css">
.m-withe {padding: 50px 20px; text-align: center;}
.m-withe .message {color: #ff0000}
.m-withe .backto {margin-top: 20px;}
.m-withe .backto a:hover{color: #ff0000;}
</style>
@endsection

@section('scripts')
<script type="text/javascript">
</script>
@endsection

@section('content')
<div class="content">
    <div class="tree-title">
        <span><i class="iconfont">&#xe605;</i> 当前位置 > 云系统 > <em>错误提示</em></span>
    </div>
    <div class="tree-content">
        <div class="m-withe">
            <div class="message">{{ $message }}</div>
            <div class="backto">
                <a href="javascript:history.back()">［返回上一页］</a>
@if (!empty($linkTo))
                <a href="{{ $linkTo }}">［{{ $linkText or '' }}］</a>
@endif
            </div>
        </div>
    </div>
</div>
@endsection
