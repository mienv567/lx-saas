<?php $_fw_HTMLTitle = '基本资料'; $_fw_ContextPath = '../'; ?>
@extends('layouts.base')

@section('head_css')
<link rel="stylesheet" type="text/css" href="../res/css/basicdata.css" />
@endsection

@section('head_js')
@endsection

@section('content')
<div class="content">
<div class="tree-title">
<span><i class="iconfont">&#xe605;</i>当前位置>首页><em>基本资料</em></span>
</div>

<div class="tree-content">
    <div class="m-withe basetit">
        <div class="left">
            <div class="headimg">
                <img src="../res/images/head_deafaul.png">
            </div>
            <div class="headcontent">
                <h1>{{ empty($user) ? '&nbsp;' : (empty($user->nickname) ? $user->username : $user->nickname) }}</h1>
                <div class="list">主体信息：{{ empty($user) ? '&nbsp;' : (empty($user->company_name) ? '&nbps;' : $user->company_name) }}</div>
                <div class="list">
                <!-- 账户ID：1543651231685465123135156 -->
                <span class="pd30"></span>
                秘钥：3211*** <a class="btn line btn-red" href="">查看</a><i class="iconfont look">&#xe606;</i>
                </div>
                <div class="list">
                    <i class="iconfont sj">&#xe608;</i>1595***8013  <a class="a-link" href="">修改</a>
                    <span class="pd30"></span>
                    <i class="iconfont sj">&#xe60a;</i>1595***8013  <a class="a-link" href="">修改</a>
                </div>
                <div class="blank0"></div>
            </div>
            <div class="blank0"></div>
        </div>
        <div class="right">
            <div class="rcontent">
                <h1>余额：</h1>
                <h2>1980.00 <a class="a-link" href="">明细</a></h2>
                <div class="btnrecharge"><a class="btn  btn-red" href="">我要充值</a></div>
            </div>
        </div>
        <div class="blank0"></div>
    </div>

    <div class="newswrap">
    <div class=" left">
        <div class="m-withe">
            <table class="table table-hover">
            <thead>
                <tr>
                  <th>站内消息<span>0</span></th>
                  <th class="textright"><a href="./articlelist.html">更多</a></th>
                </tr>
            </thead>
            <tbody>
                <tr onclick="javascript:window.location.href='./articledetail.html'">
                    <td>你是猴子请来的逗逼吗</td>
                    <td class="small">2016-04-11 &nbsp; 16:21:38</td>
                </tr>
                <tr onclick="">
                  <td>&nbsp;</td>
                  <td class="small">&nbsp;</td>
                </tr>
                <tr onclick="">
                  <td>&nbsp;</td>
                  <td class="small">&nbsp;</td>
                </tr>
                <tr onclick="">
                  <td>&nbsp;</td>
                  <td class="small">&nbsp;</td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
    <div class="right">
        <div class="m-withe">
            <table class="table table-hover">
            <thead>
                <tr>
                  <th>公告</th>
                  <th></th>
                </tr>
            </thead>
            <tbody>
                <tr onclick="">
                  <td>&nbsp;</td>
                  <td class="small">&nbsp;</td>
                </tr>
                <tr onclick="">
                  <td>&nbsp;</td>
                  <td class="small">&nbsp;</td>
                </tr>
                <tr onclick="">
                  <td>&nbsp;</td>
                  <td class="small">&nbsp;</td>
                </tr>
                <tr onclick="">
                  <td>&nbsp;</td>
                  <td class="small">&nbsp;</td>
                </tr>
            </tbody>
            </table>
        </div>
        </div>
        <div class="blank0"></div>
    </div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  /*  $(".basetit").bind('click',function(){
    alert(111);
    });*/
});
</script>
@endsection
