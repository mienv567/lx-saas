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
            <span><i class="iconfont">&#xe605;</i>当前位置>首页>账号设置><em>修改密码</em></span>
        </div>


        <div class="tree-content phonebind">
            <div class="m-withe">
                <div class="tree-contenttitle ">
                    <span>修改密码</span>
                </div>
                <div class="phonebindcontent" id="re_psw">
                    <div class="tittip"><i class="iconfont f_bluecolor">&#xe618;</i>我们不会泄露您的个人信息</div>
                    <div class="stepimg">
                        <img src="{{ asset('res/images/steppassword2.png')}}">
                    </div>
                    <div class="list error">
                        <label>重置密码</label>
                        <div class="input-wrap ">
                            <input type="password" class="W-input " id="password" name="password" value="">
                            <span class="holder-tip" style="display: block;">请输入您的新密码</span>
                        </div>
                    </div>
                    <div class="list error">
                        <label>确认密码</label>
                        <div class="input-wrap ">
                            <input type="password" class="W-input " id="password_confirmation" name="password_confirmation" value="">
                            <span class="holder-tip" style="display: block;">请再次输入您的新密码</span>
                        </div>
                    </div>
                    <div class="list save">
                        <a class="btn fit  defaul btn-red" id="button-cpsw" role="button">确定</a>
                    </div>

                </div>

            </div>
        </div>
@endsection

@section('scripts')
<script type='text/javascript' src='{{asset('res/js/send-email.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/re_email.js')}}' charset='utf-8'></script>
@endsection