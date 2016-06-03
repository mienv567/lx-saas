
(function($){
    $.fn.semail = function(options){
        var opts = $.extend(
            $.fn.semail.default,
            options
        );
        $(document).on('click', this.selector, function(e){
            var _this = $(this);
            opts = $.extend(
                opts,
                {btnContent: _this.html()}
            );
            _this.html('邮件发送中...');
            _this.prop('disabled', true);
            sendEmail(opts, _this)
        });
    };

    function sendEmail(opts, elem) {
        var email = $(opts.emailSelector).val();
        var url =  'send_code';
        $.ajax({
            url  : url,
            type : 'post',
            data : {
                _token:opts.token,
                token:opts.apiToken,
                seconds:opts.seconds,
                email:email
            },
            success : function (data) {
                if (data.success) {
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



    $.fn.semail.default = {
        token          : '',
        apiToken       : '',
        emailRule     : '',
        emailSelector : '',
        seconds        : 60,
        domain         : '',
        alertMsg       : function (msg, type) {
            alert(msg);
        }
    };


})(window.jQuery || window.Zepto);