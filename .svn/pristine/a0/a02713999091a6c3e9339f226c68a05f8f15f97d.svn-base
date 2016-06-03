
function alertSuccess(msg)
{
    _showAlertMessage('_AlertSuccess', msg, '', '#4f7787', false);
}

function alertInfo(msg)
{
    _showAlertMessage('_AlertInfo', msg, '', '', false);
}

function alertWarn(msg)
{
    _showAlertMessage('_AlertWarn', msg, '', '#f37108', false);
}

function alertError(msg)
{
    _showAlertMessage('_AlertError', msg, '', '#ff0000', false);
}

function alertConfirm(msg, callback, options)
{
    _showAlertMessage('_AlertConfirm', msg, '', '', true, callback, options);
}

function _showAlertMessage(domId, message, icon, color, isConfirm, callback, options)
{
    if (!domId) return;
    var defaultOptions = {okButtonText: '确定', cancelButtonText: '取消'};
    var panel = $('#' + domId);
    var _options = $.extend(defaultOptions, options);
    if (panel.length <= 0) {
        var html = '<div id="' + domId + '" class="marker">'
                 + '<div class="wrap">'
                 + '<div class="markerbox">'
                 + '  <div class="markercon">'
                 + '    <div class="_message_container"><font color="' + color + '">' + message + '</font></div>'
                 + '    <a class="btn btn-red btn-ok" href="javascript:void(0)">' + _options['okButtonText'] + '</a>'
                 + (isConfirm ? '    <a class="btn btn-default btn-cancel" href="javascript:void(0)" role="button">' + _options['cancelButtonText'] + '</a>' : '')
                 + '  </div>'
                 + '</div>'
                 + '</div>'
                 + '</div>';
        $('body').append(html);
        var panel = $('#' + domId);
        panel.find('a.btn-cancel').click(function(){
            $('#' + domId).removeClass('active');
        });
    } else {
        panel.find('div._message_container').html('<font color="' + color + '">' + message + '</font></p>');
    }
    panel.find('a.btn-ok').click(function(){
        var panel = $('#' + domId);
        if (panel.data('clickdoing')) {
            return;
        }
        panel.data('clickdoing', true);
        setTimeout(function(){
            $('#' + domId).data('clickdoing', false);
        }, 500);
        panel.removeClass('active');
    	if (typeof(callback) == 'function') {
            callback();
        }
    });
    $('#' + domId).addClass('active');
    var wh = $(window).height();
    var oh = $('#' + domId + ' .markerbox').height();
    $('#' + domId).css('padding-top', ((wh-oh)/2) + 'px');
}

function setElementDisabled(el, disabled)
{
    var jo = $(el);
    for (var i = 0; i < jo.length; i++) {
        var o = jo.get(i);
        o.disabled = disabled;
    }
}

$(document).ready(function(){
    // 设置ajax的csrf token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // 下拉菜单显示隐藏
	$(".navrightlist").bind('click',function(){
    	$(this).toggleClass("active");
    });
});
function refresh(){
    $('#captcha_img').attr('src',FW.DOMAIN+'captcha/default?'+Math.random());
}

$(document).ready(function() {
    setTimeout(function(){
        var mob = $("input[name='mobile']").val();
        $("input[name='username']").val(mob);
        $("input[name='email']").val(mob);
    },1000);

    $('#mobile').blur(function() {
        var mob = $("input[name='mobile']").val();
        $("input[name='username']").val(mob);
        $("input[name='email']").val(mob);
    });
    
    $(".c-left-nav").bind('click',function() {
        $(".layout-main").toggleClass("closed");
    });
})