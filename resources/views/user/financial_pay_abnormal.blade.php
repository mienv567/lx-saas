<?php $_fw_MenuIndex = 1;?>
@extends('layouts.base')
@section('styles')
<link rel="stylesheet" type="text/css" href="../res/css/system_payment.css" />
@endsection

@section('scripts')

@endsection

@section('content')
<body>
  <div class="content">
    <div class="tree-title">
    <span><i class="iconfont">&#xe605;</i>当前位置>财务管理><em>支付页面</em></span>
    </div>
    <div class="tree-content system_payment">
    <div class="m-withe">
        <div class="redtit">
            <span>无此订单</span>
        </div>
        <div class="form_hidden" style="display:none"></div>
        <div class="redtit">
            <span>选择支付方式</span>
        </div>
         <div class="paymenttab">

            <div class="rechargetab">
              <ul class="tab">
                @foreach ($paymentTypes as $key => $paymentType)
                <li class="@if ($key == 0) active first @endif" rel="{{ $paymentType->id }}"><a href="javascript:void(0);">{{ $paymentType->name }}支付</a></li>
                @endforeach
              </ul>
            </div>
            <div class="rechargetabcontent">
              @foreach ($paymentTypes as $key => $paymentType)
              <form id="form_{{ $key }}" onsubmit="return false;">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="paymentTypeId" value="{{ $paymentType->id }}">
                <div class="tabcontent @if ($key == 0) active @endif" rel="{{ $paymentType->id }}">
                  <div class="rechargestyle">
                    {!! $paymentType->getDisplayCode() !!}
                    <div class="blank0"></div>
                  </div>
                  <div class="warmtip">
                    <h1>温馨提示:</h1>
                    <ul>
                      <li>1、通过信用卡的快捷支付有500元限制，超过500元时您可以选择其他支付方式。</li>
                      <li class="f_redcolor">2、如您有欠费账单，充值后会优先补扣欠费账单。</li>
                      <li>3、充值后请及时对支付订单进行结算，以免影响正常服务。</li>
                    </ul>
                  </div>
                </div>
                <div class="yezf">
                    <div class="detaillist">
                        <label>账户余额：</label>
                        <div class="f_redcolor">￥<em class="salesprice">{{ $account }}</em></div>,
                        <div class="useyepay">
                        使用余额支付：
                        <div class="input-wrap">
                            <input type="text" class="W-input"  name="accountPay" value="" >
                            <span class="holder-tip" style="display: inline;"></span>
                        </div>
                        </div>
                        <div class="useyepay">
                            <label><input type="checkbox" name="payForAccount" value="1">使用余额全额支付</label>
                        </div>
                    </div>
                </div>
                <div class="submitbox">
                    <input class="btn defaul fit btn-red f_r" role="button" value="立即提交">
                    <div class="con"><span id="num">0</span> 件商品，应付金额：<span>￥0<em id="summoney"></em></span> </div>
                    <div class="blank0"></div>
                </div>
              </form>
              @endforeach

            </div><!-- rechargetabcontent end -->
        </div><!-- paymenttab end -->

    </div><!--m-withe end-->
    </div><!--tree-content end-->
  </div><!-- content end-->
</body>
@endsection
