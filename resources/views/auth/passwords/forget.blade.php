<?php
$_fw_HtmlTitle = '重置密码';
?>
@extends('layouts.auth')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('res/css/forgetpassword_s1.css')}}" />
@endsection

<!-- Main Content -->
@section('content')

<div class="wrap">
  <div class="forgetpassword">

    <div class="title">
       <span>重置密码</span>
    </div>
      <div class="forgetpasswordbox" id="forget">
        <div class="list spcl">
          <h1>请输入你的账号/手机/邮箱</h1>
        </div>
        <div class="list">
          <label>账号名</label>
          <div class="input-wrap ">
              <input type="text" class="W-input " id="username" name="username" value="">
              <span class="holder-tip" style="display: block;">账号/邮箱/手机号</span>
          </div>
        </div>
        <div class="list yzm">
          <label>验证码</label>
          <div class="input-wrap">
              <input type="text" class="W-input" id="captcha" name="captcha" value="">
              <span class="holder-tip" style="display: block;"></span>
          </div>
          <div class="mycode">
            <img id="captcha_img" src="{{captcha_src()}}" onclick="refresh()"/>
          </div>
          <div class="mycodechange">
            <span>看不清楚？</span>
            <a class="a-link changecode" onclick="refresh();" href="javascript:void(0);">换一张</a>
          </div>
          <div class="blank0"></div>
        </div>
          <button id="button-step1" class="btn fit defaul btn-blue">获取手机验证码</button>
      </div>
      <div class="forgetpasswordbox" style="display: none;" id="verify">
              <div id="mobile_tip" class="list spcl">
                <h1>为了账号安全，需要验证手机有效性</h1>
              </div>
             <!--  <div class="list spcl">
                <h1>为了账号安全，需要验证邮箱有效性</h1>
                <em class="fc999">一封包含有验证码的邮件已经发送至邮箱：</em><br>
                <em class="f_bluecolor">lynn314@qq.com</em>
              </div> -->
              <div class="list sjyzm">
                <label>验证码</label>
                <div class="input-wrap yzm">
                    <input type="hidden" id="mobile" name="mobile" value="">
                    <input type="text" class="W-input " id="verifyCode" name="verifyCode" value="">
                    <span class="holder-tip" style="display: block;"></span>
                </div>
                <button id="sendVerifySmsButton" class="btn defaul btn-default">再次获取验证码</button>
                <div class="tip"><i class="iconfont">&#xe612;</i><span>请输入正确的短信验证码</span></div>
              </div>
              <div class="list">
                <em class="fc999">如果一段时间没有收到，请重新获取</em>
              </div>
                <button id="button-step2" class="btn fit defaul btn-blue" >下一步</button>
        </div>
  </div>
  </div>

@endsection

@section('scripts')
<script type='text/javascript' src='{{asset('res/js/send-sms2.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/forget.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/common.js')}}' charset='utf-8'></script>
@endsection