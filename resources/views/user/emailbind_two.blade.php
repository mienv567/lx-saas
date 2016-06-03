@extends('layouts.base')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('res/css/phonebind.css')}}" />
@endsection

@section('content')
    <div class="content">
        <div class="tree-title">
            <span><i class="iconfont">&#xe605;</i>当前位置>首页>账号设置><em>邮箱绑定</em></span>
        </div>


        <div class="tree-content phonebind">
            <div class="m-withe">
                <div class="tree-contenttitle ">
                    <span>邮箱绑定</span>
                </div>
                <div class="phonebindcontent" id="verify">
                    <div class="tittip"><i class="iconfont f_bluecolor">&#xe618;</i>我们不会泄露您的个人信息</div>
                    <div class="stepimg">
                        <img src="{{ asset('res/images/stepemail2.png')}}">
                    </div>
                    <div class="list error">
                        <label>邮箱地址</label>
                        <div class="input-wrap ">
                            <input type="text" class="W-input " id="email" name="email" value="">
                            <span class="holder-tip" style="display: block;">请输入你的邮箱地址</span>
                        </div>
                    </div>
                    <div class="list sjyzm">
                        <label>验证码</label>
                        <div class="input-wrap yzm">
                            <input type="text" class="W-input " id="verifyCode" name="verifyCode" value="">
                            <span class="holder-tip" style="display: block;"></span>
                        </div>
                        <button class="btn defaul btn-default" id="sendVerifyEmailButton" >获取邮箱验证码</button>
                        <div class="tip"><i class="iconfont">&#xe612;</i><span>请输入正确的邮箱验证码</span></div>
                    </div>
                    <div class="list save">
                        <a class="btn fit  defaul btn-red" id="button-two" role="button">确定</a>
                    </div>
                    <div class="phonebindtip">
                        <h1>邮箱收不到验证码怎么办：</h1>
                        <ul>
                            <li>1、可能由于网络异常导致，请重新获取或稍后再试</li>
                            <li>2、一个账号一天最多可以发送3条验证信息</li>
                        </ul>
                    </div>

                </div>

            </div>
        </div>
@endsection

@section('scripts')
<script type='text/javascript' src='{{asset('res/js/send-email.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/re_email.js')}}' charset='utf-8'></script>
@endsection