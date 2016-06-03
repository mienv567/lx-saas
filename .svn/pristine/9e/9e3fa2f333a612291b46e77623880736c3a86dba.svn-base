<?php
$_fw_NavIndex = 3;
$_fw_AppTypeName = '云平台';
$_fw_uriPrefix = 'cloud_platform';
$_fw_HtmlTitle = '应用产品设置';
?>

@extends('cloud_base.appsys_my_detail')

@section('detail_info')
    <div class="system_tit">
    <ul class="tab">
    <li class="first active" rel="1"><a href="javascript:void(0);">产品设置</a></li>
    <li class="" rel="2"><a href="javascript:void(0);">服务详情</a></li>
    <li class="" rel="3"><a class="" href="javascript:void(0);">使用教程</a></li>
    </ul>
    <div class="blank0"></div>
    </div>
    <div class="system_detail_content">
        <div class="tabcontent tab_setting active" rel="1">
        <?php
        $user = Auth::user();
        $defaultDomain = $user->id.'.'.(isset($userProduct->product->main_domain) ? $userProduct->product->main_domain : '');
        $className = (isset($userProduct->product->class_name) ? $userProduct->product->class_name : '');
        $serviceUrl = 'http://'.$defaultDomain;
        if (!empty($className)) {
            $classFullName = 'App\Api\Product\\'.ucfirst($className);
            $productHander = new $classFullName();
            $serviceUrl = $productHander->makeServiceUrl($user, $defaultDomain);
        }
        ?>
            <div id="domainSetInput" class="pad20 detaillistbox cppzlist">
                <div class="redtit">
                    <span>授权域名</span>
                </div>
                <div class="detaillist adddomain error">
                    <label>服务地址：</label>
                    <span><a class="a-link" href="{{ $serviceUrl or '' }}" target="_blank">http://{{ $defaultDomain or '' }}</a></span>
                    <div class="blank0"></div>
                </div>
            </div>
        </div><!-- rel=1 -->
        <div class="tabcontent" rel="2">
{!! $userProduct->product->detail_introduce or '' !!}
        </div><!-- rel=2 -->
        <div class="tabcontent" rel="3">
{!! $userProduct->product->use_course or '' !!}
        </div><!-- rel=3 -->
        <div class="tabcontent" rel="4">
            &nbsp;
        </div><!-- rel=4 -->
    </div>
@endsection