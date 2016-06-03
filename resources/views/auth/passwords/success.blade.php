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
      <div class="forgetpasswordbox">

          <div class="setsuccess"><i class="iconfont f_greencolor">&#xe610;</i>密码设置成功</div>
          <button id="agree" class="btn fit defaul btn-blue"   onclick="window.location.href='{{url('/')}}'">完成</button>
      </div>
  </div>
  </div>

@endsection

@section('scripts')

<script>


</script>
@endsection