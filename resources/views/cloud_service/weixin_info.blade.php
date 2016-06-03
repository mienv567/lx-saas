<?php $_fw_HTMLTitle = '公众号管理'; $_fw_ContextPath = '../';
$_fw_NavIndex = 1;
$_fw_MenuIndex = 0;
$_fw_AppTypeName = '云服务';
$_fw_uriPrefix = 'cloud_service';
?>
@extends('layouts.base_service')

@section('styles')
    <style>
        .headcontent .list2 {
            float: left;
            padding-right: 30px;
            width: 50%;
            line-height: 40px;
            display: none;
        }
    </style>
@endsection

@section('scripts')
<script>

    $(".remove_account").bind('click',function(){
        alertConfirm("你确定要执行这个操作吗",del_account);

    });

    function del_account(){
        $.ajax({
            url: '{{ url('cloud_service/weixin_info_remove') }}',
            data: "ajax=1",
            type:"POST",
            dataType: "json",
            success: function(obj){

                if(obj.status)
                {
                    window.location.reload();
                }
                else
                {
                    alertInfo(obj.info);
                }
            }
        });
    }



    $("#syn_template").bind('click',function(){
        alertConfirm("你确定要执行这个操作吗",syn_template);

    });

    function syn_template(){
        var btn_cnt = $("#syn_template").html();
        $("#syn_template").html("同步中,请稍候......");
        $.ajax({
            url: '{{ url('cloud_service/syn_weixin_template') }}',
            data: "ajax=1",
            type:"POST",
            dataType: "json",
            success: function(obj){
                $("#syn_template").html(btn_cnt);
                if(obj.errcode==0)
                {
                    if(obj.data.success_num==0&&obj.data.fail_num==0)
                        alertInfo("同步成功 ");
                    else if(obj.data.success_num>0&&obj.data.fail_num==0)
                    {
                        alertInfo("同步成功 "+obj.data.success_num+" 条");
                    }
                    else
                        alertInfo("同步成功 "+obj.data.success_num+" 条，失败 "+obj.data.fail_num+" 条");
                }
                else
                {
                    alertInfo(obj.errmsg);
                }
            }
        });
    }


    $("#clear_template").bind('click',function(){
        alertConfirm("你确定要执行这个操作吗",clear_template);
    });

    function clear_template(){
        var btn_cnt = $("#clear_template").html();
        $("#clear_template").html("清空中，请稍候......");
        $.ajax({
            url: '{{ url('cloud_service/clear_weixin_template') }}',
            data: "ajax=1",
            type:"POST",
            dataType: "json",
            success: function(obj){
                $("#clear_template").html(btn_cnt);
                if(obj.errcode==0)
                {
                    if(obj.data.success_num==0&&obj.data.fail_num==0)
                        alertInfo("清空成功 ");
                    else if(obj.data.success_num>0&&obj.data.fail_num==0)
                    {
                        alertInfo("清空成功 "+obj.data.success_num+" 条");
                    }
                    else
                        alertInfo("清空成功 "+obj.data.success_num+" 条，失败 "+obj.data.fail_num+" 条");
                }
                else
                {
                    alertInfo(obj.errmsg);
                }
            }
        });
    }


</script>
@endsection

@section('content')
<div class="content">
<div class="tree-title">
<span><i class="iconfont">&#xe605;</i>当前位置>云服务><em>公众号管理</em></span>
</div>


    @if ($account['nick_name'])
        <div class="tree-content">
            <div class="m-withe weixinafter">
                <div class="headimg">
                    <img src="{{ $account['head_img'] }}">
                </div>
                <div class="headcontent">
                    <!--  <h1>财易通刘小葱</h1> -->
                    <div class="list">公众号名称：{{ $account['nick_name'] }}<i class="iconfont sj z-openmarker remove_account" >&#xe624;</i></div>
                    <div class="list">认证类型：{{ $verify_type }}</div>
                    <div class="list">消息模板总数：<em> @if($template_count){{$template_count}}@else 0 @endif</em>个</div>
                    <div class="list">公众号类型：{{ $service_type }}</div>
                    @if($sy_day)
                        @if(is_numeric($sy_day))
                            <div class="list">已授权：<em>{{$sy_day}}</em>天</div>
                        @else
                            <div class="list">已授权：{{$sy_day}}</div>
                        @endif
                    @else
                       <div class="list">已授权：<em>0</em>天</div>
                    @endif

                    <div class="list">已同步消息模板数：<em> @if($sy_template_count){{$sy_template_count}}@else 0 @endif</em>个</div>
                    <div class="list2">授权方公众号原始ID：@if($account['user_name']){{ $account['user_name'] }}@else 无 @endif</div><br>
                    <div class="list2">授权方appid：@if($account['authorizer_appid']) {{ $account['authorizer_appid'] }}@else 无 @endif</div>
                    <div class="blank0"></div>
                </div>
                <div class="btnbox">
                    <a class="btn fit  defaul btn-red z-openmarker" id="syn_template"  href="javascript:;">同步微信消息模板</a>
                    <a class="btn fit  defaul btn-red z-openmarker" id="clear_template"  href="javascript:;">清空微信消息模板</a>
                </div>
                <div class="blank0"></div>
            </div>
        </div>
    @else
        <div class="tree-content weixinauthorize">
            <div class="m-withe">
        @if ($sq_url)
                    <div class="tree-contenttitle">
                        <div class="img f_l"><img src="{{ asset('res/images/weixin.png')}}"></div>
                        <div class="con f_l">您暂未进行公众号授权，为了我们更好的对您服务，请进行公众号授权<a class="btn line btn-red" href="{{ $sq_url }}" target="_blank">授权微信公众号</a></div>
                        <div class="blank0"></div>
                    </div>
                    <div class="stepbox">

                    </div>
                    <div class="authorizetip">
                        <h1>授权前须知：</h1>
                        <h2>1.授权登录不会对您的公众号造成任何影响！自定义菜单、回复规则及素材等将保持原样；</h2>
                        <h2>2.公众号授权登录需要公众号的管理员扫描完成，请确保您是管理员或可以联系他协助您完成授权；</h2>
                        <h2>3.为了保证您能正常使用平台所有功能，强烈建议您在授权登录时请直接点击底部【授权】按钮，请不要自定义授权的权限；</h2>
                        <h2>4.微信为不同类型的公众号提供不同的接口权限，我们以此提供的功能亦不同，部分服务权限表如下；</h2>
                    </div>
                    <div class="authorizetable">

                        <table class="table table-bordered ">
                            <thead>
                            <tr>
                                <th></th>
                                <th>订阅号</th>
                                <th>服务号</th>
                                <th class="textright">认证订阅号</th>
                                <th>认证服务号</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>配置菜单</td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                            </tr>
                            <tr>
                                <td>自动回复</td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                            </tr>
                            <tr>
                                <td>创建图文</td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                            </tr>
                            <tr>
                                <td>配置智能标签</td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                            </tr>
                            <tr>
                                <td>使用应用商店</td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                            </tr>
                            <tr>
                                <td>数据报告</td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                            </tr>

                            <tr>
                                <td>粉丝管理</td>
                                <td><i class="iconfont f_redcolor">&#xe622;</i></td>
                                <td><i class="iconfont f_redcolor">&#xe622;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                            </tr>
                            <tr>
                                <td>创建卡券</td>
                                <td><i class="iconfont f_redcolor">&#xe622;</i></td>
                                <td><i class="iconfont f_redcolor">&#xe622;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                            </tr>
                            <tr>
                                <td>微信摇一摇</td>
                                <td><i class="iconfont f_redcolor">&#xe622;</i></td>
                                <td><i class="iconfont f_redcolor">&#xe622;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                            </tr>
                            <tr>
                                <td>定时群发</td>
                                <td><i class="iconfont f_redcolor">&#xe622;</i></td>
                                <td><i class="iconfont f_redcolor">&#xe622;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                            </tr>
                            <tr>
                                <td>公众号广播</td>
                                <td><i class="iconfont f_redcolor">&#xe622;</i></td>
                                <td><i class="iconfont f_redcolor">&#xe622;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                            </tr>
                            <tr>
                                <td>带参二维码</td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                            </tr>
                            <tr>
                                <td>微信支付</td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                            </tr>
                            <tr>
                                <td>发送模板消息</td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                            </tr>
                            <tr>
                                <td>网页授权</td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                                <td><i class="iconfont f_greencolor">&#xe610;</i></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="blank15"></div>
                    <div class="blank15"></div>
                @else
            {{ $error }}
        @endif
            </div>
        </div>
    @endif

@endsection
