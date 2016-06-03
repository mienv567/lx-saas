<?php
$_fw_MenuIndex = 2;
$_fw_HtmlTitle = '账号设置';
?>
@extends('layouts.base')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('res/css/phonebind.css')}}" />
@endsection

@section('content')
<div class="content">
    <div class="tree-title">
        <span><i class="iconfont">&#xe605;</i>当前位置>首页><em>账号设置</em></span>
    </div>


    <div class="tree-content phonebind">
        <div class="m-withe">
            <div class="tree-contenttitle ">
                <span>账号设置</span>
            </div>
            @if($account->mobile)
            <div class="phonebindcontent st2">
                <div class="tittip"><i class="iconfont f_bluecolor">&#xe618;</i>您正在使用手机验证码验证身份，请完成以下操作</div>
                <div class="stepimg"><img src="{{ asset('res/images/stepimg1.png')}}"></div>
                <div class="list sjyzm">
                    手机号：{{ Utils::maskPhone($account->mobile) }} &nbsp;&nbsp;
                    <input type="hidden"  id="mobile" name="mobile" value="{{$account->mobile}}">
                </div>
                <div class="list sjyzm" id="verify">
                    <div class="input-wrap yzm">
                        <input type="text" class="W-input " id="verifyCode" name="verifyCode" value="">
                        <span class="holder-tip" style="display: block;"></span>
                    </div>
                    <button id="sendVerifySmsButton" class="btn defaul btn-default">获取手机验证码</button>
                    <div class="tip"><i class="iconfont">&#xe612;</i><span>请输入正确的手机验证码</span></div>
                </div>
                <div class="list save">
                    <a class="btn fit  defaul btn-red" id="button-one" role="button">确定</a>
                </div>
                <div class="phonebindtip">
                    <h1>手机收不到验证码怎么办：</h1>
                    <ul>
                        <li>1、可能由于网络异常导致，请重新获取或稍后再试</li>
                        <li>2、请核实手机是否屏蔽系统短信，若已停用或丢失，请使用其他验证方式</li>
                        <li>3、一个账号一天最多可以发送3条验证短信</li>
                    </ul>
                </div>
            </div>
            @else
            <div class="phonebindcontent st2">
                <div class="tittip"><i class="iconfont f_bluecolor">&#xe618;</i>您正在绑定手机号，请完成以下操作</div>
                <div class="stepimg"><img src="{{ asset('res/images/stepimg1.png')}}"></div>
                <div class="list sjyzm">
                   请填写密码 &nbsp;&nbsp;
                </div>
                <div class="list sjyzm" id="verify" style="width: 300px;">
                    <div class="input-wrap yzm">
                        <input type="password" class="W-input " id="password" name="password" value="">
                        <span class="holder-tip" style="display: block;"></span>
                    </div>
                </div>
                <div class="list save">
                    <a class="btn fit  defaul btn-red" id="button-one" role="button">确定</a>
                </div>
            </div>
            @endif

        </div>
    </div>
@endsection

@section('scripts')
<script type='text/javascript' src='{{asset('res/js/send-sms2.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/rephone.js')}}' charset='utf-8'></script>

<script type="text/javascript">
     var url = "phonebind_verify"
</script>
@endsection