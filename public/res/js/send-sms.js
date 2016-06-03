
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
        var captcha = $(opts.captchaSelector).val();
        var password = $(opts.passwordSelector).val()
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
                password:password,
                captcha:captcha,
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
                    $('#captcha_img').attr('src',FW.DOMAIN+'captcha/default?'+Math.random());
                    opts.alertMsg(data.message, data.type);
                }
            },
            error: function(xhr, type){
                elem.html(opts.btnContent);
                elem.prop('disabled', false);
                $('#captcha_img').attr('src',FW.DOMAIN+'captcha/default?'+Math.random());
                opts.alertMsg('请求失败，请重试');
            }
        });
    }

    function timer(elem, seconds, btnContent){
        if(seconds >= 0){
            setTimeout(function(){
                //显示倒计时
                elem.html(seconds + ' 秒后再次发送');
                //递归
                seconds -= 1;
                timer(elem, seconds, btnContent);
            }, 1000);
        }else{
            elem.html(btnContent);
            elem.prop('disabled', false);
        }
    }



    $.fn.sms.default = {
        token          : '',
        apiToken       : '',
        mobileRule     : '',
        mobileSelector : '',
        passwordSelector:'',
        captchaSelector : '',
        seconds        : 60,
        voice          : false,
        domain         : '',
        alertMsg       : function (msg, type) {
            alert(msg);
        }
    };


})(window.jQuery || window.Zepto);