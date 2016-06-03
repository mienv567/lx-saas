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
                    <span>邮箱绑定</span>
                </div>
                <div class="phonebindcontent">
                    <div class="stepimg"> <img src="{{ asset('res/images/stepemail3.png')}}"> </div>
                    <div class="stepsuccess">
                        <i class="iconfont f_greencolor">&#xe610;</i>
                        <h1>恭喜您，邮箱绑定成功！</h1>
                        <a class="btn line btn-default" href="{{ url('user/account_setting') }}" role="button">返回首页</a>
                    </div>
                </div>

            </div>
        </div>
@endsection

@section('scripts')
<script type='text/javascript' src='{{asset('res/js/send-email.js')}}' charset='utf-8'></script>
<script type='text/javascript' src='{{asset('res/js/re_email.js')}}' charset='utf-8'></script>
@endsection