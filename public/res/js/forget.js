(function ($) {

    $('#button-step1').on('click', function( e ) {

        $.ajax({
            url: '/password/forget',
            type: 'POST',
            data: $('#forget :input'),
            dataType: 'json',
            beforeSend: function() {
                $('#button-step1').html('正在提交...');
            },
            complete: function() {
                $('#button-step1').html('获取手机验证码');
            },
            success: function(json) {
                $('.tip').remove();

                if(json.err == 0){
                    $('#verify').find('input[name="mobile"]').val(json.msg)
                    $('#forget').hide();
                    $('#verify').show();
                    $("#sendVerifySmsButton").trigger("click");
                }else{
                    if(json.err > 0){
                        if (json['msg'] && json['msg'] != '') {
                            $.each(json['msg'], function(i,val){
                                $('#'+i).parent().parent().addClass('error');
                                $('#'+i).parent().parent().append('<div class="tip"><i class="iconfont">&#xe612;</i><span>' + val + '</span></div>');
                            });
                        }
                    }
                    if(json.err < 0){
                        alert(json['msg']);
                    }
                    refresh();
                }

            },
            error: function(xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                alertError('网络或服务异常');
            }
        });
        e.preventDefault();
    });

    $('#button-step2').on('click', function( e ) {

        $.ajax({
            url: '/password/verify',
            type: 'POST',
            data: $('#verify :input'),
            dataType: 'json',
            beforeSend: function() {
                $('#button-step2').html('正在提交...');
            },
            complete: function() {
                $('#button-step2').html('下一步');
            },
            success: function(json) {
                $('.tip').remove();

                if(json.err == 0){
                    var redirect_url = '/';

                    if(json.redirect && json.redirect.length)
                    {
                        redirect_url = json.redirect;
                    }
                    window.location.href = redirect_url;
                }else{
                    if(json.err > 0){
                        if (json['msg'] && json['msg'] != '') {
                            $.each(json['msg'], function(i,val){
                                $('#'+i).parent().parent().addClass('error');
                                $('#'+i).parent().parent().append('<div class="tip"><i class="iconfont">&#xe612;</i><span>' + val + '</span></div>');
                            });
                        }
                    }
                    if(json.err < 0){
                        alert(json['msg']);
                    }
                    refresh();
                }

            },
            error: function(xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                alertError('网络或服务异常');
            }
        });
        e.preventDefault();
    });

    $('#button-reset').on('click', function( e ) {

        $.ajax({
            url: '/password/reset',
            type: 'POST',
            data: $('#box-reset :input'),
            dataType: 'json',
            beforeSend: function() {
                $('#button-reset').html('正在提交...');
            },
            complete: function() {
                $('#button-reset').html('下一步');
            },
            success: function(json) {
                $('.tip').remove();

                if(json.err == 0){
                    var redirect_url = '/';

                    if(json.redirect && json.redirect.length)
                    {
                        redirect_url = json.redirect;
                    }
                    window.location.href = redirect_url;
                }else{
                    if(json.err > 0){
                        if (json['msg'] && json['msg'] != '') {
                            $.each(json['msg'], function(i,val){
                                $('#'+i).parent().parent().addClass('error');
                                $('#'+i).parent().parent().append('<div class="tip"><i class="iconfont">&#xe612;</i><span>' + val + '</span></div>');
                            });
                        }
                    }
                    if(json.err < 0){
                        alertInfo(json['msg']);
                    }
                    refresh();
                }

            },
            error: function(xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                alertError('网络或服务异常');
            }
        });
        e.preventDefault();
    });

}(jQuery));

$('#sendVerifySmsButton').sms({
    token          : $('meta[name="csrf-token"]').attr('content'),

    //json api token
    apiToken       : '',

    mobileSelector : 'input[name="mobile"]',

    //手机号必填
    mobileRule     : 'check_mobile',

    voice          : false,

    domain : FW.DOMAIN,

    alertMsg       :  function (msg, type) {
        $('.tip').remove();

        if(type == 'validation_captcha'){
            $('#captcha').parent().parent().addClass('error');
            $('#captcha').parent().parent().append('<div class="tip"><i class="iconfont">&#xe612;</i><span>' + msg + '</span></div>');
        }else if(type == 'mobile_required'){
            $('#mobile').parent().parent().addClass('error');
            $('#mobile').parent().parent().append('<div class="tip"><i class="iconfont">&#xe612;</i><span>' + msg + '</span></div>');
        }else if(type == 'sms_send_success'){
            $("#mobile_tip em").remove();
            $("#mobile_tip br").remove();
            var mobile = $('#verify').find('input[name="mobile"]').val();
            $('#mobile_tip').append('<em class="fc999">一条包含有验证码的短信已经发送至手机：</em><br>'
            +'<em class="f_bluecolor">'
            +mobile
            +'</em>');
        }else{
            $('#verifyCode').parent().parent().addClass('error');
            $('#verifyCode').parent().parent().append('<div class="tip"><i class="iconfont">&#xe612;</i><span>' + msg + '</span></div>');
        }
    }
});

