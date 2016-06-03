$('#sendVerifySmsButton').sms({   //手机验证码  换手机号旧手机验证
    token          : $('meta[name="csrf-token"]').attr('content'),

    //json api token
    apiToken       : '',

    mobileSelector : 'input[name="mobile"]',

    captchaSelector : 'input[name="captcha"]',

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
        }else{
            $('#verifyCode').parent().parent().addClass('error');
            $('#verifyCode').parent().parent().append('<div class="tip"><i class="iconfont">&#xe612;</i><span>' + msg + '</span></div>');
        }
    }
});

$('#button-one').on('click', function( e ) {

    $.ajax({
        url: url,
        type: 'POST',
        data: $('#verify :input'),
        dataType: 'json',
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



$('#button-res').on('click', function( e ) {  //重置key

    $.ajax({
        url: 'user/resAppCert',
        type: 'POST',
        data: $('#verify :input'),
        dataType: 'json',
        success: function(json) {
            $('.tip').remove();

            if(json.err == 0){
                alertInfo('重置成功');
                setTimeout('window.location.reload()',500);
            }else{
                if(json.err > 0){
                    if (json['msg'] && json['msg'] != '') {
                        $.each(json['msg'], function(i,val){
                            $('#'+i).parent().parent().addClass('error');
                            $('#'+i).parent().parent().append('<div class="tip"><i class="iconfont">&#xe612;</i><span>' + val + '</span></div>');
                        });
                    }
                }
            }

        },
        error: function(xhr, ajaxOptions, thrownError) {
            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            alertError('网络或服务异常');
        }
    });
    e.preventDefault();
});
