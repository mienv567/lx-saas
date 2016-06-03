$('#sendVerifyEmailButton').semail({   //旧手机验证码
    token          : $('meta[name="csrf-token"]').attr('content'),

    //json api token
    apiToken       : '',

    emailSelector : 'input[name="email"]',

   emailRule     : 'check_email',

    voice          : false,

    alertMsg       :  function (msg, type) {
        $('.tip').remove();
        if(type == 'request_invalid'){
            $('#verifyCode').parent().parent().addClass('error');
            $('#verifyCode').parent().parent().append('<div class="tip"><i class="iconfont">&#xe612;</i><span>' + msg + '</span></div>');
        }else if(type == 'email_required'){
            $('#email').parent().parent().addClass('error');
            $('#email').parent().parent().append('<div class="tip"><i class="iconfont">&#xe612;</i><span>' + msg + '</span></div>');
        }else{
            $('#verifyCode').parent().parent().addClass('error');
            $('#verifyCode').parent().parent().append('<div class="tip"><i class="iconfont">&#xe612;</i><span>' + msg + '</span></div>');
        }
    }
});

$('#button-two').on('click', function( e ) {

    $.ajax({
        url: 'email_code',
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




$('#button-cpsw').on('click', function( e ) {

    $.ajax({
        url: 'cpsw_re',
        type: 'POST',
        data: $('#re_psw :input'),
        dataType: 'json',
        beforeSend: function() {
            $('#button-cpsw').html('正在提交...');
        },
        complete: function() {
            $('#button-cpsw').html('下一步');
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


