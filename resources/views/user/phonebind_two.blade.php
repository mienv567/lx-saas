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
                <div class="phonebindcontent" id="verify">
                    <div class="tittip"><i class="iconfont f_bluecolor">&#xe618;</i>我们不会泄露您的手机信息</div>
                    <div class="stepimg"><img src="{{ asset('res/images/stepimg2.png')}}"> </div>
                    <div class="list error">
                        <label>手机号码</label>
                        <div class="input-wrap ">
                            <input type="text" class="W-input " id="mobile" name="mobile" value="">
                            <span class="holder-tip" style="display: block;">请输入你的手机号</span>
                        </div>
                    </div>
                    <div class="list sjyzm">
                        <label>验证码</label>
                        <div class="input-wrap yzm">
                            <input type="text" class="W-input " id="verifyCode" name="verifyCode" value="">
                            <span class="holder-tip" style="display: block;"></span>
                        </div>
                        <button class="btn defaul btn-default" id="sendVerifySmsButton_new">获取手机验证码</button>
                        <div class="tip"><i class="iconfont">&#xe612;</i><span>请输入正确的手机验证码</span></div>
                    </div>
                    <div class="list save">
                        <a id="button-two" class="btn fit  defaul btn-red" href="./phonebind_three.html" role="button">确定</a>
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

            </div>
        </div>
@endsection

@section('scripts')
<script type='text/javascript' src='{{asset('res/js/send-sms2.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/rephone_step2.js')}}' charset='utf-8'></script>
@endsection