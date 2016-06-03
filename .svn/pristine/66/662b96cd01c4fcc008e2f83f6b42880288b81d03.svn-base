<?php
$_fw_MenuIndex = 0;
$_fw_HtmlTitle = '公告详情';
?>
@extends('layouts.base')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('res/css/system_list.css')}}" />
<style>
.form-control {
    border-radius: 0;
    box-shadow: none;
    border-color: #d2d6de;
}
</style>
@endsection

@section('content')
    <div class="content">
        <div class="tree-title">
            <span><i class="iconfont">&#xe605;</i>当前位置>首页><em>公告</em></span>
        </div>

        <div class="tree-content system_list">
            <div class="m-withe">
                <div class="articledetailbox">
                    <div class="articledetailtit">
                        {{$bulletin->title}}
                    </div>
                    <div class="articledetailcon">
                        {!!$bulletin->content!!}
                        <p class="textright">方维云平台</p>
                        <p class="textright"> {{$bulletin->created_at}}</p>
                        {{--<p class="textright">2016年5月9日</p>--}}
                    </div>
                </div>
            </div><!--m-withe end-->
        </div><!--tree-content end-->
    </div><!-- content end-->
@endsection

@section('scripts')

@endsection