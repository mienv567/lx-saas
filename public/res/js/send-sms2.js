
(function($){
    $.fn.sms = function(options){
        var opts = $.extend(
            $.fn.sms.default,
            options
        );
        $(document).on('click', this.selector, function(e){
            var _this = $(this);
            opts = $.extend(
                opts,
                {btnContent: _this.html()}
            );
            _this.html('短信发送中...');
            _this.prop('disabled', true);
            sendSms(opts, _this)
        });
    };

    function sendSms(opts, elem) {
        var mobile = $(opts.mobileSelector).val();
        var url = opts.domain + 'sms/verify-code';
        if (opts.voice) {
            url = opts.domain + 'sms/voice-verify';
        }
        $.ajax({
            url  : url,
            type : 'post',
            data : {
                _token:opts.token,
                token:opts.apiToken,
                seconds:opts.seconds,
                mobile:mobile,
                mobileRule:opts.mobileRule
            },
            success : function (data) {
                if (data.success) {
                    $('#button-register').prop('disabled', false);
                    timer(elem, opts.seconds, opts.btnContent);
                    opts.alertMsg(data.message, data.type);
                } else {
                    elem.html(opts.btnContent);
                    elem.prop('disabled', false);
                    opts.alertMsg(data.message, data.type);
                }
            },
            error: function(xhr, type){
                elem.html(opts.btnContent);
                elem.prop('disabled', false);
                opts.alertMsg('请求失败，请重试');
            }
        });
    }

    var altimer = null;
    function timer(elem, seconds, btnContent){
        if(seconds >= 0){
            altimer = setTimeout(function(){
                //显示倒计时
                elem.html(seconds + ' 秒后可再次发送');
                //递归
                seconds -= 1;
                timer(elem, seconds, btnContent);
            }, 1000);
        }else{
            elem.html(btnContent);
            elem.prop('disabled', false);
        }
    }

  /////////////////////////////////////////////////////////////////////
    $('#button-mobile_key').on('click', function( e ) {  //显示key 并且消除倒计时
        $.ajax({
            url: url,
            type: 'POST',
            data: $('#verify :input'),
            dataType: 'json',
            success: function(json) {
                $('.tip').remove();

                if(json.err == 0){
                    $('#mobileAppCert').hide();
                    $('#userAppSecretMark').text(json.appkey);
                    $('#userAppSecretShowBtn').hide();
                    $('#userAppSecrethideBtn').show();
                    $("input[name=app_sec]").val(json.appkey);
                    $("input[name=lo_appkey]").val('1');
                    clearTimeout(altimer);
                    $('#sendVerifySmsButton').removeAttr("disabled");
                    $('#sendVerifySmsButton').text("获取手机验证码");
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


    $.fn.sms.default = {
        token          : '',
        apiToken       : '',
        mobileRule     : '',
        mobileSelector : '',
        seconds        : 60,
        voice          : false,
        domain         : '',
        alertMsg       : function (msg, type) {
            alert(msg);
        }
    };


})(window.jQuery || window.Zepto);