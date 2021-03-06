<?php $_fw_MenuIndex = 1; ?>
@extends('layouts.base_system')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ url('res/css/system_detail.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('res/css/system_detail_extra.css') }}" />
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    //删除商品removetr
    $(".removetr").click(function(){
        $(this).parents("tr").remove();
        sum();
    });
    $(".upgrade .choosebox").bind("click",function(){
        $(this).siblings(".choosebox").removeClass("active");
        $(this).addClass("active");
        
        var price = $(this).attr("data-price");
        var upgradepackage = $(this).attr("data-upgradepackage");
        var url=$(this).attr("data-url");
        $(this).parents(".upgrade").find(".price").text(price);
        $(this).parents(".upgrade").find(".lookdetail").text(upgradepackage);
        $(this).parents(".upgrade").find(".lookdetail").attr("href",url);
    });
});
</script>
@endsection

@section('content')
<div class="content">
<div class="tree-title">
<span><i class="iconfont">&#xe605;</i>当前位置 > 云系统 > <em>应用设置</em></span>
</div>

<div class="tree-content system_detail">
@if (empty($userProduct))
<div class="m-withe system_detailtit">
    该应用产品不存在或还未购买！
</div>
@else
<div class="m-withe system_detailtit">
    <div class="productimgbox"><img alt="" src="{{ $userProduct->product->main_image or url('res/images/indexhead.png') }}"> </div>
    <div class="f_l system_detailinfo">
        <h1>{{ $userProduct->product_name or '' }} - {{ $userProduct->sale_item_name or '' }}</h1>
        <h2>{{ $userProduct->product->brief_introduce or '' }}</h2>
        <div class="detaillistbox">
        <div class="detaillist">
            <label>授权信息：</label>
<?php
$buyInfo = empty($userProduct->buy_info) ? null : json_decode($userProduct->buy_info);
$licenseDomainCount = 0;
$licenseDayCount = 0;
$licenseFuncPackage = '';
if (!empty($buyInfo)) {
    $licenseDomainCount = empty($buyInfo->license_domain_count) ? 0 : intval($buyInfo->license_domain_count);
    $licenseDayCount = empty($buyInfo->license_day_count) ? 0 : intval($buyInfo->license_day_count);
    $licenseFuncPackage = empty($buyInfo->license_func_package) ? '' : $buyInfo->license_func_package;
}
?>
            <ul>
               <li class="domains">授权<strong>{{ $licenseDomainCount or '' }}</strong>个域名</li>
               <li class="split">|</li>
    @if ($licenseDayCount > 0)
               <li class="months">授权<strong>{{ $licenseDayCount or '' }}</strong>天</li>
    @else
               <li class="months">不限授权期限</li>
    @endif
    @if (!empty($licenseFuncPackage))
               <li class="split">|</li>
               <li class="package">功能套餐号：{{ $licenseFuncPackage or '' }}</li>
    @endif
            </ul>
        </div>
        <div class="detaillist">
            <label>购买时间：</label>
            {{ date('Y-m-d H:i:s', strtotime($userProduct->created_at)) }}
        </div>
        <div class="detaillist">
            <label>到期时间：</label>
    @if ($licenseDayCount > 0)
            {{ date('Y-m-d H:i:s', strtotime('+'.$licenseDayCount.' day', strtotime($userProduct->created_at))) }}
    @else
            永不过期
    @endif
        </div>
        <div class="detaillist">
            <label>证书下载：</label>
            <a class="a-link" href="javascript:void(0);" role="button">下载</a>
        </div>
        </div>
    </div>
    <div class="blank0"></div>
</div>
<div class="blank10"></div>
<div class="m-withe">
    <div class="system_tit">
    <ul class="tab">
    <li class="first active" rel="1"><a href="javascript:void(0);">产品配置</a></li>
    <li class="" rel="2"><a href="javascript:void(0);">服务详情</a></li>
    <li class="" rel="3"><a class="" href="javascript:void(0);">使用教程</a></li>
    <li class="" rel="4"><a class="" href="javascript:void(0);">订购记录</a></li>
    </ul>
    <div class="blank0"></div>
    </div>
    <div class="system_detail_content">
        <div class="tabcontent active" rel="1">
            <div class="pad20 detaillistbox cppzlist">
                <div class="redtit">
                    <span>域名授权</span>
                </div>
                <div class="detaillist adddomain error">
                    <label>添加域名：</label>
                    <div class="input-wrap f_l">
                        <input type="text" class="W-input " id="" name="" value="">
                        <span class="holder-tip"></span>
                    </div>
                    <a class="btn defaul btn-red btnadddomain f_l" href="#" role="button">添加</a>
                    <div class="domainprice f_l">
                        单价：<span class="f_redcolor">￥168000.00<em></em> </span>
                    </div>
                    <div class="tip"><i class="iconfont"></i><span>请输入正确的域名</span></div>
                    <div class="blank0"></div>
                </div>
            </div>
            <div class="sqtable">
                <table class="table table-hover">
                <thead>
                    <tr>
                      <th>域名授权</th>
                      <th>创建时间</th>
                      <th>状态</th>
                      <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                      <td>www.fanwe.com</td>
                      <td>2016-04-11 &nbsp; 16:21:38</td>
                      <td><span class="f_redcolor">待支付</span></td>
                      <td><a class="a-link removetr" href="javascript:void(0);">删除</a> </td>
                    </tr>
                    <tr>
                      <td>www.fanwe.com</td>
                      <td>2016-04-11 &nbsp; 16:21:38</td>
                      <td><span class="f_greencolor">已创建</span></td>
                      <td><a class="a-link" href="javascript:void(0);">禁用</a> </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div class="pad20 detaillistbox cppzlist upgrade">
                <div class="redtit">
                    <span>套餐升级</span>
                </div>
                <div class="detaillist">
                    <label>当前套餐：</label>
                    普通型
                </div>
                <div class="detaillist ">
                    <label>升级套餐：</label>
                    <div class="chooseboxes">
                    <div class="choosebox" data-price="0" data-upgradepackage="您选择了不升级哦" data-url="javascript:void(0);" >不升级</div>
                    <div class="choosebox" data-price="28888" data-upgradepackage="查看标准版详情" data-url="./system_detail.html">标准版</div>
                    <div class="choosebox" data-price="38888" data-upgradepackage="查看高级版详情" data-url="./system_detail.html">高级版</div>
                    <div class="choosebox" data-price="68888" data-upgradepackage="查看旗舰版详情" data-url="./system_detail.html">旗舰版</div>
                    <div class="blank0"></div>
                    </div>
                </div>
                <div class="detaillist">
                    <label>套餐详情：</label>
                    <a class="a-link lookdetail" href="">查看旗舰版详情</a>
                </div>
                <div class="detaillist">
                    <label>价格：</label>
                    <span>￥<em class="price">16800.00</em></span>
                </div>
            </div>
            <div class="pad20 detaillistbox cppzlist">
                <div class="redtit">
                    <span>产品续费</span>
                </div>
                <div class="detaillist">
                    <label>到期时间：</label>
                    2016-04-11 &nbsp; 16:21:38
                </div>
                <div class="detaillist">
                    <label>延长时间：</label>
                    <div class="chooseboxes">
                    <div class="choosebox active" data-price="0" data-upgradepackage="0" data-url="./system_detail.html">无</div>
                    <div class="choosebox" data-price="28888" data-salesprice="20888">一个月</div>
                    <div class="choosebox" data-price="38888" data-salesprice="30888">一季度</div>
                    <div class="choosebox" data-price="68888" data-salesprice="60888">半年</div>
                    <div class="choosebox" data-price="98888" data-salesprice="90888">一年</div>
                    <div class="blank0"></div>
                    </div>
                </div>
                <div class="detaillist">
                    <label>价格：</label>
                    <em>￥16800.00</em>
                </div>
            </div>
            <div class="pad20 detaillistbox cppzlist">
                <div class="redtit">
                    <span>更新配置</span>
                </div>
                <div class="detaillist ">
                    <label>服务器IP：</label>
                    <div class="input-wrap f_l">
                        <input type="text" class="W-input " id="" name="" value="">
                        <span class="holder-tip"></span>
                    </div>
                    <div class="blank0"></div>
                </div>
                <div class="detaillist">
                    <label>密码：</label>
                    <div class="input-wrap f_l">
                        <input type="text" class="W-input " id="" name="" value="">
                        <span class="holder-tip"></span>
                    </div>
                    <div class="blank0"></div>
                </div>
                <!-- <div class="detaillist ">
                    <a class="btn defaul btn-red btnadddomain" href="#" role="button">确认配置</a>
                </div> -->
                <div class="blank85"></div>
            </div>
            <div class="submitfoot pad20">
                <div class="submitfoot1">价格合计：￥<span class="f_redcolor">16800.00</span></div>
                <div class="submitfoot2">
                    <a class="btn defaul btn-red btnadddomain" href="#" role="button">保存配置</a>
                </div>
            </div>


        </div><!-- rel=1 -->
        <div class="tabcontent" rel="2">
            2
        </div><!-- rel=2 -->
        <div class="tabcontent" rel="3">
            3
        </div><!-- rel=3 -->
        <div class="tabcontent" rel="4">
            4
        </div><!-- rel=4 -->
       
    </div>
</div><!--m-withe end-->
@endif
</div><!--tree-content end-->
</div><!-- content end-->
@endsection
