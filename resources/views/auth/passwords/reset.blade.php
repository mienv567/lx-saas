<?php
$_fw_HtmlTitle = '重置密码';
?>
@extends('layouts.auth')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('res/css/forgetpassword_s1.css')}}" />
@endsection

@section('content')
  <div class="wrap">
  <div class="forgetpassword">
    <div class="title">
       <span>重置密码</span>
    </div>
      <div class="forgetpasswordbox" id="box-reset">
        <div class="list ">
          <label>重置密码</label>
          <div class="input-wrap ">
              <input type="password" class="W-input " id="password" name="password" value="">
              <span class="holder-tip" style="display: block;">密码长度为6-20字符</span>
          </div>
        </div>
        <div class="list ">
          <label>确认密码</label>
          <div class="input-wrap ">
              <input type="password" class="W-input " id="password_confirmation" name="password_confirmation" value="">
              <span class="holder-tip" style="display: block;"></span>
          </div>
        </div>
          <button id="button-reset" class="btn fit defaul btn-blue" >下一步</button>
      </div>
  </div>
  </div>

@endsection

@section('scripts')
<script type='text/javascript' src='{{asset('res/js/send-sms2.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/forget.js')}}' charset='utf-8'></script>
@endsection