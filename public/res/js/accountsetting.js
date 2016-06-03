(function ($) {

    $('#button-setting').on('click', function( e ) {

        $.ajax( {
            url: '/user/account_setting',
            type: 'POST',
            data: {
                company_name: $("input#company_name").val(),
                company_address: $("input#company_address").val(),
                company_phone: $("input#company_phone").val(),
                province_id: $("#province_id").val(),
                city_id: $("#city_id").val(),
                county_id: $("#county_id").val()
            },
            dataType: 'json',
            beforeSend: function() {
                $('#button-setting').html('正在提交...');
            },
            complete: function() {
                $('#button-setting').html('修改');
            },
            success:function(json)
            {
                $('.tip').remove();

                if(json.err == 0){
                    alertSuccess(json.msg);
                }else{
                    if (json['msg'] && json['msg'] != '') {
                        $.each(json['msg'], function(i,val){
                            $('#'+i).parent().parent().addClass('error');
                            $('#'+i).parent().parent().append('<div class="tip"><i class="iconfont">&#xe612;</i><span>' + val + '</span></div>');
                        });
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {

            }
        });
        e.preventDefault();
    });
}(jQuery));


jQuery(function($) {

    var ratio = window.devicePixelRatio || 1;

    var config = {
        // 缩略图大小
        thumbnailWidth: 100 * ratio,
        thumbnailHeight: 100 * ratio
    }
    initImage({ imagePicker:'#avatar',imageList:'#avatar img', thumbnailWidth: config.thumbnailWidth, thumbnailHeight: config.thumbnailHeight});

});

function initImage(config) {
    // 图片相关
    var uploader = WebUploader.create({
        // 自动上传。
        auto: true,

        // swf文件路径
        swf: FW.DOMAIN+'res/libs/webuploader/Uploader.swf',

        // 文件接收服务端。
        server: '/user/avatar',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: config.imagePicker,

        //fileNumLimit: 1,

        formData: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },

        // 只允许选择文件，可选。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });


    // 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) {

        $img = $(config.imageList);

        // 创建缩略图
        uploader.makeThumb( file, function( error, src ) {
            if ( error ) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }

            $img.attr( 'src', src );
        }, config.thumbnailWidth, config.thumbnailHeight );
    });

    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress span');

        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<p class="progress"><span></span></p>')
                .appendTo( $li )
                .find('span');
        }

        $percent.css( 'width', percentage * 100 + '%' );
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on( 'uploadSuccess', function( file,obj ) {
        $( '#'+file.id ).addClass('upload-state-done');
        $('#zhutipath').val(obj.savepath);
    });

    // 文件上传失败，现实上传出错。
    uploader.on( 'uploadError', function( file ) {
        var $li = $( '#'+file.id ),
            $error = $li.find('div.error');

        // 避免重复创建
        if ( !$error.length ) {
            $error = $('<div class="error"></div>').appendTo( $li );
        }

        $error.text('上传失败');
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').remove();
    });

}
