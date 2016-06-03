<div class="financialist2">
  @if ($consumeStartTime or $consumeEndTime)
    @if ($consumeStartTime)
      {{$consumeStartTime}}
    @else
      不限
    @endif
    &nbsp;至&nbsp;
    @if ($consumeEndTime)
      {{$consumeEndTime}}
    @else
      不限
    @endif
    &nbsp;
  @endif消费总计：<em class="f_themecolor">{{ $totalConsume }}</em>
</div>
<div class="financialist3">
    <table class="table table-hover">
    <thead>
        <tr>
          <th>消费时间</th>
          <th>接收号码</th>
          <th>发送内容</th>
          <th>使用数量</th>
          <th>失败数量</th>
          <th>发送结果</th>
          <th>短信类型</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($consumes as $consume)
        <tr onclick="">
          <td>{{ date('Y-m-d H:i:s',$consume['create_time'] )}}</td>
          <td>{{$consume['mobiles']}}</td>
          <td title="{{$consume['content']}}">@if(strlen($consume['content'])>40){{mb_substr($consume['content'], 0,20, 'utf-8').'...'}}@else{{$consume['content']}}@endif</td>
          <td>{{$consume['all_count']}}</td>
          <td>{{$consume['bad_count']}}</td>
          <td>@if($consume['status']==0)待发送@elseif($consume['status']==1)发送成功@else发送失败@endif</td>
          <td>@if($consume['is_adv']==0)普通短信@elseif($consume['is_adv']==1)营销短信@else验证码@endif</td>
        </tr>
      @endforeach
    </tbody>
    </table>
</div>
<div class="financialist4">
    @if(sizeof($render))
      <a class="btn defaul  btn-default f_r" href="javascript:loadSmsConsumeLogSelectedPage('sms_consume_log?uid={{$uid}}&put_consume_start_time={{ $consumeStartTime }}&put_consume_end_time={{ $consumeEndTime }}&page=');" role="button">GO</a>
      <div class="input-wrap f_r">
          <input type="text" class="W-input " id="consume-page" value="" data-form-un="1460442869071.4133">
          <span class="holder-tip" style="display: inline;"></span>
      </div>
      <ul class="pagination f_r">
        <li @if($page==1)class="disabled" @endif>
          <a @if($page!=1) href="javascript:LoadConsumePage('sms_consume_log?uid={{$uid}}&put_consume_start_time={{ $consumeStartTime }}&put_consume_end_time={{ $consumeEndTime }}&page={{$page-1}}');"@endif aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        @foreach ($render as $r)
        <li class="  @if($r==$page) active @endif @if($r=='...') disabled @endif"><a @if($r!='...')href="javascript:LoadConsumePage('sms_consume_log?uid={{$uid}}&put_consume_start_time={{ $consumeStartTime }}&put_consume_end_time={{ $consumeEndTime }}&page={{$r}}');" @endif>{{$r}}</a></li>
        @endforeach
        <li @if($page==$render[sizeof($render)-1])class="disabled" @endif>
          <a @if($page!=$render[sizeof($render)-1]) href="javascript:LoadConsumePage('sms_consume_log?uid={{$uid}}&put_consume_start_time={{ $consumeStartTime }}&put_consume_end_time={{ $consumeEndTime }}&page={{$page+1}}');"@endif aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    @endif
  <span class="f_garycolor f_r">共有{{$totalCount}}条，每页显示：{{$page_size}}条</span>
  <div class="blank0"></div>
</div>

