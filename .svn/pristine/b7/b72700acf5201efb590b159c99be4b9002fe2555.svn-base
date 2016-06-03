<?php $_fw_MenuIndex = 1;?>
@extends('layouts.base')
@section('styles')
<link rel="stylesheet" type="text/css" href="../res/css/m_financial_rechargedetail.css" />
@endsection

@section('scripts')
<script type='text/javascript' src='{{asset('res/js/jquery.dateinputpack.js')}}' charset='utf-8'></script>
<script type="text/javascript">
$(document).ready(function(){
    $(".controldetail").bind("click",function(){
        $(this).toggleClass("zclose");
        if ($(this).hasClass("zclose")) {
            $(".zfztcontent").addClass("zclose");
            $(this).find("span").text("展开扣款详情");
        }else{
            $(".zfztcontent").removeClass("zclose");
            $(this).find("span").text("收起扣款详情");
        };
    });
});
</script>

@endsection

@section('content')
<body>
<div class="content">
<div class="tree-title">
<span><i class="iconfont">&#xe605;</i>当前位置>首页>财务管理><em>账单详情</em></span>
</div>

<div class="tree-content account_setting">
    <div class="m-withe">
        <div class="tree-contenttitle ">
            <span>充值单号：{{ $payment->payment_no }}<a class="btn line btn-default" href="{{ url('user/finance_manage') }}" role="button"><i class="iconfont">&#xe617;</i>返回列表</a></span>
        </div>

        <div class="tree-padding">
            <table class="table table-bordered tbgy">
            <thead>
                <tr>
                  <th colspan="2">概要</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                  <td>产品：余额充值</td>
                  <td>充值单号：{{ $payment->payment_no }}</td>
                </tr>
                <tr>
                  <td>账单时间：{{ $payment->created_at }}</td>
                  <td>充值金额：￥{{ $payment->pay_money }}</td>
                </tr>
            </tbody>
            </table>
        <div class="zfzt">
            <div class="tit">
                <div class="f_r controldetail"><span>收起扣款详情</span> <i class="iconfont">&#xe60c;</i></div>
                <div class="blank0"></div>
            </div>
            <div class="zfztcontent">

            <table class="table table-hover tbgydetail">
            <thead>
                <tr>
                  <th>充值流水编号</th>
                  <th>充值来源</th>
                  <th>扣款费用</th>
                  <th>充值时间</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                  <td>{{ $payment->out_trade_no }}</td>
                  <td>{{ $payment->paymentType->name }}充值</td>
                  <td><span class="f_bluecolor">￥{{ $payment->pay_money }}</span> </td>
                  <td>{{ $payment->pay_time }}</td>
                </tr>
            </tbody>
            </table>
            </div>
            <div class="blank15"></div>
        </div>
        </div>



</div>

</body>
@endsection
