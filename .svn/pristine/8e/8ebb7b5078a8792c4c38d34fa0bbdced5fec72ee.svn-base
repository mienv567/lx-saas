<?php
$_fw_NavIndex = 2;
$_fw_AppTypeName = '云系统';
$_fw_uriPrefix = 'cloud_system';
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
            <div id="domainSetInput" class="pad20 detaillistbox cppzlist">
                <div class="redtit">
                    <span>授权域名设置</span>
                </div>
                <div class="detaillist adddomain error">
                    <label>添加域名：</label>
                    <div class="input-wrap f_l">
                        <input type="text" class="W-input " id="domain" name="" value="">
                        <span class="holder-tip"></span>
                    </div>
                    <a class="btn defaul btn-red btnadddomain f_l" href="javascript:addDomain()" role="button">添加</a>
                    <div class="tip" style="display:none;"><i class="iconfont"></i><span>请输入正确的域名</span></div>
                    <div class="blank0"></div>
                </div>
            </div>
<?php
$settingInfo = empty($userProduct->setting_info) ? null : json_decode($userProduct->setting_info);
$licenseInfo = null;
$coreConfigInfo = null;
if (!empty($settingInfo)) {
    $licenseInfo = isset($settingInfo->licenseInfo) ? $settingInfo->licenseInfo : null;
    $coreConfigInfo = isset($settingInfo->coreConfigInfo) ? $settingInfo->coreConfigInfo : null;
}
?>
            <div id="domainSetList" class="sqtable">
                <table class="table table-hover">
                <thead>
                    <tr>
                      <th width="70%">域名授权</th>
                      <th width="30%">操作</th>
                    </tr>
                </thead>
                <tbody>
    @if (!empty($licenseInfo) && !empty($licenseInfo->domains) && count($licenseInfo->domains) > 0 )
<script type="text/javascript">var _OriginDomainCount = {{ count($licenseInfo->domains) }};</script>
        @foreach ($licenseInfo->domains as $domain)
                    <tr>
                      <td class="domain">{{ $domain }}</td>
                      <td class="operation">&nbsp;</td>
                    </tr>
        @endforeach
    @else
<script type="text/javascript">var _OriginDomainCount = 0;</script>
    @endif
                </tbody>
                </table>
            </div>
<?php
$coreConfigItemJson = empty($userProduct->product->core_config_item) ? null : $userProduct->product->core_config_item;
$coreConfigItems = empty($coreConfigItemJson) ? array() : json_decode($coreConfigItemJson);
?>
    @if (count($coreConfigItems) > 0 )
            <div id="coreConfigSet" class="pad20 detaillistbox cppzlist">
                <div class="redtit">
                    <span>系统参数设置</span>
                </div>
        @foreach ($coreConfigItems as $coreConfigItem)
                <div id="_cc_{{ $coreConfigItem->name or '' }}" class="detaillist ">
                    <label>{{ $coreConfigItem->caption }}：</label>
                    <div class="input-wrap f_l {{  $coreConfigItem->inputtype == 'select' ? 'input-wrap-select' : '' }}">
            @if ($coreConfigItem->inputtype == 'select')
                        <select id="_cc_{{ $coreConfigItem->name or '' }}" name="{{ $coreConfigItem->name or '' }}" value="{{ $coreConfigItem->value or '' }}" need="{{ $coreConfigItem->required or '' }}">
                @if (isset($coreConfigItem->inputitems))
                    @foreach ($coreConfigItem->inputitems as $item)
                            <option value="{{ $item->value or '' }}">{{ $item->text or '' }}<option>
                    @endforeach
                @endif
                        </select>
            @else
                        <input id="_ccinput_{{ $coreConfigItem->name or '' }}" name="{{ $coreConfigItem->name or '' }}" type="{{ $coreConfigItem->inputtype == 'number' ? 'number' : 'text' }}" class="W-input " value="{{ $coreConfigItem->value or '' }}" need="{{ $coreConfigItem->required or '' }}">
            @endif
                        <span class="holder-tip"></span>
                    </div>
                    <span class="tip" style="display:none;"><i class="iconfont"></i><span>此信息项必须填写</span></span>
                    <div class="blank0"></div>
                </div>
        @endforeach
        @if (!empty($coreConfigInfo))
<script type="text/javascript">
var ccInitValues = [];
            @foreach ($coreConfigInfo as $key=>$value)
                @if (!empty($key))
ccInitValues["{{ $key or ''}}"] = "{{ $value or '' }}";
                @endif
            @endforeach
</script>
        @endif
    @endif
                <div class="blank15"></div>
            </div>
            <div class="submitfoot pad20">
                <div class="submitfoot2">
                    <button id="saveConfigButton" type="button" class="btn defaul btn-red btnadddomain" onclick="saveProductSet()">保存配置</button>
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


