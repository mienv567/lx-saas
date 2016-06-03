<?php
$_fw_MenuIndex = 2;
$_fw_HtmlTitle = '账号设置';
?>
@extends('layouts.base')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('res/css/account_setting.css')}}" />
<style>
.form-control {
    border-radius: 0;
    box-shadow: none;
    border-color: #d2d6de;
}
.account_setting .headimg {
    padding: 0;
    background-position: center center;
    background-size: cover;
}
.account_setting .webuploader-pick {
    width: 100%;
    height: 100%;
}
.account_setting .headimg img {
    width: 100%;
    height: 100%;
}
</style>
@endsection

@section('content')
<div class="content">
<div class="tree-title">
<span><i class="iconfont">&#xe605;</i>当前位置>首页><em>账号设置</em></span>
</div>


<div class="tree-content account_setting">
    <div class="m-withe">
        <div class="tree-contenttitle ">
            <span>账号设置</span>
        </div>
        <div class="tree-contentlisthead">
            <div class="headimg f_l" id="avatar" style="background-image: url( {{ url(($account->photo) ? $account->photo : asset('res/images/head_deafaul.png')) }} )">
                <a>
                <img style="" src="{{ url('res/images/blank.png') }}">
                <div class="edit">编辑头像</div>
                </a>
            </div>
            <div class="f_l headcontent">
                <h2>登录账号：{{$account->username}}</h2>
                <h2>账号ID：{{$account->id}}</h2>
                <h2>注册时间：{{$account->created_at}}</h2>
            </div>
            <div class="blank0"></div>
        </div>
        <form id="form-setting" method="post" action="">
        <div class="tree-contentlist">
            <h1>基本信息</h1>
            <div class="list name">
                <label class="caption"><em class="f_redcolor">*</em>公司名称：</label>
                <div class="input-wrap">
                    <input type="text" class="W-input " id="company_name" name="company_name" value="{{$account->company_name}}">
                    <span class="holder-tip" style="display: inline;"></span>
                </div>
                <div class="tip"><i class="iconfont">&#xe612;</i><span>请输入公司名称</span></div>
            </div>

            <h1>联系信息</h1>
            <div class="list area" style="width: 600px;">
                <label class="caption"><em class="f_redcolor">*</em>所在地区：</label>
                <div class="form-group " style="float: left; padding-right:5px;">
                    <select class="stlectdefault form-control" style="width: auto;" id="province_id" name="province_id"></select></div>
                    <div class="form-group " style="float: left; padding-right:5px;"><select class="stlectdefault form-control" style="width: auto;" id="city_id" name="city_id"></select></div>
                    <div class="form-group "><select class="stlectdefault form-control" style="width: auto;" id="county_id" name="county_id"></select></div>


            </div>
            <div class="list ">
                <label class="caption">街道地址：</label>
                <div class="input-wrap">
                    <input type="text" class="W-input " id="company_address" name="company_address" value="{{$account->company_address}}">
                    <span class="holder-tip" style="display: inline;"></span>
                </div>
            </div>
            <div class="list ">
                <label class="caption">联系电话：</label>
                <div class="input-wrap">
                    <input type="text" class="W-input " id="company_phone" name="company_phone" value="{{$account->company_phone}}">
                    <span class="holder-tip" style="display: inline;">例如：0591-88888888</span>
                </div>
            </div>
            <div class="list save error">
                <a class="btn fit  defaul btn-red" id="button-setting" href="javascript:;" role="button">修改</a>
            </div>
        </div>
        </form>
        <div class="tree-contentlist2">
            <label>登录密码</label>
            <div class="f_l">
            安全性高的密码可以使账号更安全。建议您定期更换密码，设置一个包含字母，符号或数字中至少两项且长度超过6位的密码。
            </div>
            <a class="a-link f_r" href="{{ url('user/cpsw_one') }}">修改</a>

            <div class="blank0"></div>
        </div>
        <div class="tree-contentlist2">
            <label>手机绑定</label>
            <div class="f_l">
            @if($account->mobile)
            您已绑定手机<span class="f_greencolor">{{ Utils::maskPhone($account->mobile) }}</span>.[您的手机为安全手机，可以找回密码，但不能用于登录；为保障您账户安全，如果换绑手机，5天内只能操作一次。]
            @else
            您还未绑定手机
            @endif
            </div>
            <a class="a-link f_r" href="{{ url('user/phonebind_one') }}">修改</a>
            @if($account->mobile)
                <span class="f_r setted f_greencolor"><i class="iconfont">&#xe613;</i>已设置</span>
            @else
                <span class="f_r setted f_orangecolor"><i class="iconfont">&#xe61d;</i>未设置</span>
            @endif
            <div class="blank0"></div>
        </div>

        {{--<div class="tree-contentlist2">
            <label>邮箱绑定</label>
            <div class="f_l">
                @if($account->email)
                您已绑定邮箱<span class="f_greencolor">{{$account->email}}</span>.
                @else
                您还未绑定邮箱
                @endif
            </div>
            <a class="a-link f_r" href="{{ url('user/email_one') }}">修改</a>
            @if($account->email)
            <span class="f_r setted f_greencolor"><i class="iconfont">&#xe613;</i>已设置</span>
            @else
            <span class="f_r setted f_orangecolor"><i class="iconfont">&#xe61d;</i>未设置</span>
            @endif
            <div class="blank0"></div>
        </div>--}}
        <div class="blank15"></div>
        <div class="blank15"></div>
    </div>


</div>
</div>
@endsection

@section('scripts')
<!--引入CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('/res/libs/webuploader/css/webuploader.css') }}">

<!--引入JS-->
<script type="text/javascript" src="{{ asset('/res/libs/webuploader/js/webuploader.min.js') }}"></script>
<script type='text/javascript' src='{{asset('res/js/accountsetting.js')}}' charset='utf-8'></script>
<script src="{{ asset('/res/js/region.js') }}"></script>
<script type="text/javascript">



	$(document).ready(function() {
        var sel = new select({
            data: location_data
        });

        @if($account->company_area_id > 0)
            var county = "{{$account->company_area_id}}";
            var province_city;
            for(var key in location_data){
                for(var ikey in location_data[key]){
                    if(ikey==county){
                        province_city=key;
                    }
                }
            }
            province_city = province_city.split(',');
            var province = province_city[1],city = province_city[2];

            sel.bind($('#province_id'),province);
            sel.bind($('#city_id'),city);
            sel.bind($('#county_id'),county);

        @else
            sel.bind($('#province_id'));
            sel.bind($('#city_id'));
            sel.bind($('#county_id'));
        @endif

	});
</script>

@endsection