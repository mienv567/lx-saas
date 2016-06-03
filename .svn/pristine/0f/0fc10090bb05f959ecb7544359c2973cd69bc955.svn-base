$(document).ready(function(){
    // 调整系统参数设置项的Label宽度
    var ccLabels = $('#coreConfigSet .detaillist label');
    var width = 0;
    ccLabels.each(function(index, element) {
        width = Math.max(width, $(element).width());
    });
    if (width > 0) {
        ccLabels.width(width);
    }
    // 用已配置的值初始化系统参数设置值
    if (typeof(ccInitValues) != 'undefined') {
        for (var key in ccInitValues) {
            $('#_ccinput_' + key).val(ccInitValues[key]);
        };
    }
    // 删除商品removetr
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
    // 域名输入框change事件处理
    $("#domain").keyup(function(){
        hideDomainError();
    });
});
function showDomainError(msg)
{
    $('#domainSetInput .adddomain .tip span').html(msg);
    $('#domainSetInput .adddomain .tip').show();
}
function hideDomainError()
{
    $('#domainSetInput .adddomain .tip').hide();
}
function getDomains()
{
    var domainTds = $('#domainSetList table tbody tr td.domain');
    var domains = [];
    for (var i = 0; i < domainTds.length; i++) {
        var o = domainTds.eq(i);
        var domain = $.trim(o.text());
        if (domain) {
            domains.push(domain);
        }
    }
    return domains;
}
function addDomain()
{
    var limitCount = parseInt($('#licenseDomainCount').val());
    var domain = $.trim($('input#domain').val());
    var domains = getDomains();
    if (isNaN(limitCount)) {
        limitCount = 0;
    }
    if (!domain) {
        showDomainError('请输入正确的域名！');
    } else if ($.inArray(domain, domains) >= 0) {
        showDomainError('该域名已经存在，请重新输入！');
    } else if (limitCount > 0 && domains.length >= limitCount) {
        showDomainError('已达授权上限，不能再添加！');
    } else {
        hideDomainError();
        var html = '<tr>'
                 + '<td class="domain">' + domain + '</td>'
                 + '<td class="operation"><a class="a-link removetr" href="javascript:void(0);">删除</a></td>'
                 + '</tr>';
        $('#domainSetList table tbody').append(html);
        $(".removetr").click(function(){
            $(this).parents("tr").remove();
            sum();
        });
    }
}
function saveProductSet()
{
    // 获取授权域名设置信息并判断
    var domains = getDomains();
    if (domains.length <= 0) {
        showDomainError('授权域名不能为空，请添加！');
        return;
    }
    hideDomainError();
    // 判断是否有新增域名，如果有，那么进行确认提示
    var originDomainCount = typeof(_OriginDomainCount) == 'undefined' ? 0 : _OriginDomainCount;
    var hintMsg = '保存配置操作将会重新生成授权文件，是否继续？';
    if (domains.length > originDomainCount) {
        hintMsg = '域名新增后将无法删除和修改，是否继续提交？';
    }
    alertConfirm(hintMsg, function() {
        execSaveProductSet(domains);
    });
}
function execSaveProductSet(domains)
{
    // 先禁用保存按钮
    setElementDisabled('#saveConfigButton', true);
    // 获取系统参数设置信息并判断
    var inputs = $('#coreConfigSet input,#coreConfigSet select');
    var hasError = false;
    var configs = {};
    for (var i = 0; i < inputs.length; i++) {
        var o = inputs.eq(i);
        var name = o.attr('name');
        var required = o.attr('need');
        var value = $.trim(o.val());
        if ((required == '1' || required =='true') && !value) {
            $('#_cc_' + name + ' .tip').show();
            if (!hasError) o.focus();
            hasError = true;
        } else {
            $('#_cc_' + name + ' .tip').hide();
            configs[name] = value;
        }
    }
    if (hasError) {
        setElementDisabled('#saveConfigButton', false);
        return;
    }
    // 提交保存
    var configInfo = {id: $('#userProductId').val(), 'domains': domains, 'coreConfigs': configs};
    $.ajax({
        url: 'myproduct_set',
        type: 'post',
        data: {data: JSON.stringify(configInfo)},
        dataType: "json",
        success: function(data) {
            setElementDisabled('#saveConfigButton', false);
            if (data.errcode == 0) {
                var licenseId = (data.data) ? data.data.licenseid : '';
                var licenseDownHTML = (licenseId) ? '<a class="a-link" href="down_license?id=' + licenseId + '" role="button" target="_blank">下载</a>' :  '';
                $('#domainSetList td.operation a').html('&nbsp;');
                if (licenseDownHTML) {
                    $('#licensefile').html(licenseDownHTML);
                }
                alertSuccess('产品设置保存成功，并已更新授权文件');
            } else {
                alertError(data.errmsg);
            }
        },
        error: function(xhr, ts, et) {
            setElementDisabled('#saveConfigButton', false);
            alertError('网络或服务异常');
        }
    });
}
function createCloudPlatformLicense()
{
    var params = {id: $('#userProductId').val()};
    $.ajax({
        url: 'myproduct_set',
        type: 'post',
        data: {data: JSON.stringify(params)},
        dataType: "json",
        success: function(data) {
            if (data.errcode == 0) {
                alertSuccess('授权文件生成成功');
                var licenseId = data.data ? data.data.licenseid : '';
                var html = '<a class="a-link" href="down_license?id=' + licenseId + '" role="button" target="_blank">下载</a>';
                $('#licensefile').html(html);
            } else {
                alertError(data.errmsg);
            }
        },
        error: function(xhr, ts, et) {
            alertError('网络或服务异常');
        }
    });
}