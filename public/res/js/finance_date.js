$(document).ready(function() {
    var start = {   //订单明细
        elem: '#activitystart1',
        format: 'YYYY-MM-DD hh:mm:ss',
        min: '2000-06-16 23:59:59', //设定最小日期为当前日期
        max: '2099-06-16 23:59:59', //最大日期
        istime: true,
        istoday: false,
        choose: function(datas){
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };
    var end = {
        elem: '#activityend1',
        format: 'YYYY-MM-DD hh:mm:ss',
        min: '2000-06-16 23:59:59',
        max: laydate.now(),
        istime: true,
        istoday: false,
        choose: function(datas){
            start.max = datas; //结束日选好后，重置开始日的最大日期
        }
    };
    $('#activitystart1').bind("click",function(){
        laydate(start);
    });
    $('#activityend1').bind("click",function(){
        laydate(end);
    });






    var start2 = {   //充值明细
        elem: '#activitystart2',
        format: 'YYYY-MM-DD hh:mm:ss',
        min: '2000-06-16 23:59:59', //设定最小日期为当前日期
        max: '2099-06-16 23:59:59', //最大日期
        istime: true,
        istoday: false,
        choose: function(datas){
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };
    var end2 = {
        elem: '#activityend2',
        format: 'YYYY-MM-DD hh:mm:ss',
        min: '2000-06-16 23:59:59',
        max: laydate.now(),
        istime: true,
        istoday: false,
        choose: function(datas){
            start.max = datas; //结束日选好后，重置开始日的最大日期
        }
    };
    $('#activitystart2').bind("click",function(){
        laydate(start2);
    });
    $('#activityend2').bind("click",function(){
        laydate(end2);
    });






    var start3 = {   ///消费明细
        elem: '#activitystart3',
        format: 'YYYY-MM-DD hh:mm:ss',
        min: '2000-06-16 23:59:59', //设定最小日期为当前日期
        max: '2099-06-16 23:59:59', //最大日期
        istime: true,
        istoday: false,
        choose: function(datas){
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };
    var end3 = {
        elem: '#activityend3',
        format: 'YYYY-MM-DD hh:mm:ss',
        min: '2000-06-16 23:59:59',
        max: laydate.now(),
        istime: true,
        istoday: false,
        choose: function(datas){
            start.max = datas; //结束日选好后，重置开始日的最大日期
        }
    };
    $('#activitystart3').bind("click",function(){
        laydate(start3);
    });
    $('#activityend3').bind("click",function(){
        laydate(end3);
    });

});