<?php
$_fw_MenuIndex = 0;
$_fw_HtmlTitle = '站内消息列表';
?>
@extends('layouts.base')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('res/css/system_list.css')}}" />
<style>
.form-control {
    border-radius: 0;
    box-shadow: none;
    border-color: #d2d6de;
}
.box-footer {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-right-radius: 3px;
    border-bottom-left-radius: 3px;
    border-top: 1px solid #f4f4f4;
    padding: 10px;
    background-color: #fff;
}
.pagination {
    display: inline-block;
    padding-left: 0;
    margin: 20px 0;
    border-radius: 4px;
}
</style>
@endsection

@section('content')
    <div class="content">
        <div class="tree-title">
            <span><i class="iconfont">&#xe605;</i>当前位置>首页><em>站内信</em></span>
        </div>

        <div class="tree-content system_list">
            <div class="m-withe">
                <div class="system_tit">
                    <ul class="tab f_l">
                        <li class="first active" rel="1"><a href="javascript:void(0);">全部</a></li>
                    </ul>
                    <div class="right">
                        <a class="btn btn-default defaul f_r" href="#" role="button" id="search_title" ">搜索</a>
                        <div class="input-wrap f_r">
                            <input type="text" class="W-input " id="message" name="title" value="{{$search_title}}" data-form-un="1460442869071.4133">
                            <span class="holder-tip" style="display: inline;">请输入文章名称进行模糊查询</span>
                        </div>
                    </div>
                    <div class="blank0"></div>
                </div>
                <div class="article_list_content" style="padding-top:20px;">
                    <div class="tabcontent active" rel="1">
                        <div class="articlelisttable">
                            <table class="table table-hover">
                                <tbody>
                                @if(isset($messages))
                                @foreach($messages as $item)
                                <tr onclick="javascript:window.location.href='{{url('user/message_detail')}}?id={{$item->id}}'">
                                    <td><span class="a-link">{{$item->title}}</span> </td>
                                    <td class="textright">{{$item->created_at}}</td>
                                </tr>
                                @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div><!-- rel=1 -->
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                    @if($messages){!!$messages->appends(['title'=>$search_title])->render()!!}@endif
                        </ul>
                    </div>
                </div>
            </div><!--m-withe end-->
        </div><!--tree-content end-->
    </div><!-- content end-->
@endsection

@section('scripts')
    <script type="text/javascript">
        $('#search_title').on('click', function() {
            var url = 'message_list?';
            var title = $('input[name=\'title\']').val();
            if (title) {
                url += 'title=' + encodeURIComponent(title);
            }
            location = url;
        });
    </script>

@endsection