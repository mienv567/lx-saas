@extends('layouts.auth')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('res/css/login.css')}}" />
@endsection

@section('content')
<div class="loginbackground">
  <div class="wrap">
    <div class="loginbox">
    <form role="form" name="LoginForm" method="POST" action="{{ url('/login') }}" class="form">
        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
    {!! csrf_field() !!}
    <div class="tittle">
      <div class="left">
        账号登录
      </div>
      <div class="right">
        没有账号？<a class="a-link" href="{{ url('/register') }}">免费注册</a>
      </div>
    </div>
    <div class="logincontent">
    @if (count($errors)>0)
    <div class="tip ">
        @foreach ($errors->all() as $error)
            <i class="iconfont">&#xe612;</i><span>{{ $error }}</span>
        @endforeach
    </div>
    @endif
      <div class="blank15"></div>
      <div class="input-wrap icon">
          <input type="text" class="W-input " id="mobile" name="mobile" value="">
          <span class="holder-tip" style="display: inline;">用户名/手机</span>
          <i class="iconfont left">&#xe60e;</i>
          <i class="iconfont changefade"></i>
          <input type="hidden" name="username" value="">
          <input type="hidden" name="email" value="">
      </div>
      <div class="input-wrap icon">
          <input type="password" class="W-input " id="password" name="password" value="">
          <span class="holder-tip" style="display: inline;">密码</span>
          <i class="iconfont left">&#xe60f;</i>
          <i class="iconfont changefade"></i>
      </div>
      <div class="list yzm">
            <div class="input-wrap icon">
                <input type="text" class="W-input" id="captcha" name="captcha">
                <span class="holder-tip" style="display: block;">验证码</span>
                <i class="iconfont left">&#xe621;</i>
            </div>
            <div class="mycode">
                <img id="captcha_img" src="{{captcha_src()}}" onclick="refresh()"/>
            </div>
            <div class="mycodechange">
                <a class="a-link changecode" onclick="refresh();" href="javascript:void(0);">换一张</a>
            </div>
            <div class="blank0"></div>
      </div>
      <div class="list">
          <a href="{{ url('password/forget') }}">忘记密码？</a>
      </div>
      <button type="submit" class="btn fit defaul btn-blue" id="sum">
          登录
      </button>
    </div>
    </form>
    </div>
  </div>
</div>


@endsection

@section('scripts')
    <script type='text/javascript' src='{{asset('res/js/common.js')}}' charset='utf-8'></script>
@endsection
