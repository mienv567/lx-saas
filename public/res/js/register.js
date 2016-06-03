(function ($) {

    $('#button-register').on('click', function( e ) {

        $.ajax({
            url: '/register',
            type: 'POST',
            data: {
                mobile: $("input#mobile").val(),
                verifyCode: $("input#verifyCode").val(),
                password: $("input#password").val()
            },
            dataType: 'json',
            beforeSend: function() {
                $('#button-register').html('正在提交...');
            },
            complete: function() {
                $('#button-register').html('同意协议并注册');
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
                    if (json['msg'] && json['msg'] != '') {
                        $.each(json['msg'], function(i,val){
                            $('#'+i).parent().parent().addClass('error');
                            $('#'+i).parent().parent().append('<div class="tip"><i class="iconfont">&#xe612;</i><span>' + val + '</span></div>');
                        });
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

}(jQuery));

$('#sendVerifySmsButton').sms(
    {
    token          : $('meta[name="csrf-token"]').attr('content'),

    //json api token
    apiToken       : '',

    mobileSelector : 'input[name="mobile"]',

    captchaSelector : 'input[name="captcha"]',

    //手机号必填
    mobileRule     : 'mobile_required',

    passwordSelector : 'input[name="password"]',

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
        }else if(type == 'password_required'){
            $('#password').parent().parent().addClass('error');
            $('#password').parent().parent().append('<div class="tip"><i class="iconfont">&#xe612;</i><span>' + msg + '</span></div>');
        }else{
            $('#verifyCode').parent().parent().addClass('error');
            $('#verifyCode').parent().parent().append('<div class="tip"><i class="iconfont">&#xe612;</i><span>' + msg + '</span></div>');
        }
    }
});
