<?php
$_fw_HtmlTitle = '用户注册';
?>
@extends('layouts.auth')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('res/css/register.css')}}" />
@endsection

@section('content')
  <div class="wrap">
  <div class="register">
      <div class="left">
      <div class="registerbox">
      <form id="form-register" method="POST" action="{{ url('/register') }}" class="form">
          {!! csrf_field() !!}
        <h1>使用手机注册</h1>
        <div class="list">
          <label>手机号码</label>
          <div class="input-wrap ">
              <input type="text" class="W-input " id="mobile" name="mobile" value="{{ old('mobile') }}">
              <span class="holder-tip" style="display: block;">请输入你的手机号</span>
          </div>

        </div>
        <div class="list yzm">
          <label>验证码</label>
          <div class="input-wrap">
              <input type="text" class="W-input" id="captcha" name="captcha">
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
        <div class="list">
          <label>设置密码</label>
          <div class="input-wrap">
              <input type="password" class="W-input " id="password" name="password" >
              <span class="holder-tip" style="display: block;">密码长度6-20字符</span>
          </div>

        </div>
        <div class="list sjyzm">
          <label>手机验证码</label>
          <div class="input-wrap yzm">
              <input type="text" class="W-input " id="verifyCode" name="verifyCode" value="">
              <span class="holder-tip" style="display: block;"></span>
          </div>
          <button type="button" id="sendVerifySmsButton" class="btn defaul btn-default">获取手机验证码</button>
        </div>
        <div class="list">
          <em class="fc999">如果一段时间没有收到，请重新获取</em>
        </div>
        <div class="list">
          <button id="button-register" class="btn fit defaul btn-blue" disabled="disabled" type="button">同意协议并注册</button>
        </div>
        <div class="list">
          <a class="a-link" href="#">《使用条款和协议》</a>
        </div>

</form>
      </div>
      </div>
      <div class="right">
        <h1>已经注册过？</h1>
        <h2>请点击<a class="a-link" href="{{ url('/login') }}">直接登录</a> </h2>
      </div>
      <div class="blank0"></div>
  </div>
  </div>
@endsection

@section('scripts')
<script type='text/javascript' src='{{asset('res/js/send-sms.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/register.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/common.js')}}' charset='utf-8'></script>

@endsection