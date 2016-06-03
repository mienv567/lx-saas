@extends('layouts.auth')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('res/css/forgetpassword_s1.css')}}" />
@endsection

<!-- Main Content -->
@section('content')

<div class="wrap">
  <div class="forgetpassword">
  <form method="POST" action="{{ url('/password/email') }}">
  {!! csrf_field() !!}
    <div class="title">
       <span>重置密码</span>
    </div>
      <div class="forgetpasswordbox">
        <div class="list spcl">
          <h1>请输入你的手机号/邮箱</h1>
          @if (session('status'))
                                  <div class="alert alert-success">
                                      {{ session('status') }}
                                  </div>
                              @endif
        </div>
        <div class="list {{ $errors->has('email') ? ' error' : '' }}">
          <label>账号名</label>
          <div class="input-wrap ">
              <input type="text" class="W-input " id="" name="" value="">
              <span class="holder-tip" style="display: block;">邮箱/手机号</span>
          </div>
          <div class="tip"><i class="iconfont">&#xe612;</i><span>请输入正确的账号名</span></div>
        </div>
        <div class="list yzm">
          <label>验证码</label>
          <div class="input-wrap">
              <input type="text" class="W-input" name="email" value="{{ old('email') }}">
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
          @if ($errors->has('email'))
          <div class="tip"><i class="iconfont">&#xe612;</i><span>{{ $errors->first('email') }}</span></div>
           @endif

        </div>
          <button id="agree" class="btn fit defaul btn-blue" type="submit">下一步</button>
      </div>
        </form>
  </div>
  </div>

@endsection

@section('scripts')

<script>

function refresh(){
    $('#captcha_img').attr('src','/captcha/default?'+Math.random());
}

</script>
@endsection