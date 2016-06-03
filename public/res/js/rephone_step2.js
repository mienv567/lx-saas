/*$('#mobile').on('blur', function( e ) {
    if (!$("#mobile").val().match(/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/))
    {
       $("#mobile").parent().parent().append('<div class="tip"><i class="iconfont">&#xe612;</i><span>请输入正确的手机号</span></div>');
       $("#mobile").focus();
       return false;
    }else{
        $('.tip').remove();
    }
});*/


$('#sendVerifySmsButton_new').sms({   //换成新机验证码
    token          : $('meta[name="csrf-token"]').attr('content'),

    //json api token
    apiToken       : '',

    mobileSelector : 'input[name="mobile"]',

    captchaSelector : 'input[name="captcha"]',

    //手机号必填
    mobileRule     : 'mobile_required',

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


$('#button-two').on('click', function( e ) {

    $.ajax({
        url: 'two_verify',
        type: 'POST',
        data: $('#verify :input'),
        dataType: 'json',
        beforeSend: function() {
            $('#button-one').html('正在提交...');
        },
        complete: function() {
            $('#button-one').html('下一步');
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
