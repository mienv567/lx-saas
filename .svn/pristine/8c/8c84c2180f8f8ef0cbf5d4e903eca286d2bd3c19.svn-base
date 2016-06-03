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
  @endif消费总计：<em class="f_themecolor">￥{{ $totalConsume }}</em>
</div>
<div class="financialist3">
    <table class="table table-hover">
    <thead>
        <tr>
          <th>消费时间</th>
          <th>消费形式</th>
          <th>消费金额</th>
          <th>订单号</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($consumes as $consume)
        <tr onclick="">
          <td>{{ $consume['create_time'] }}</td>
          <td>{{ $consume['operator'] }}</td>
          <td>￥{{ round($consume['fee'],2) }}</td>
          <td>{{ $consume['orderno'] }}</td>
        </tr>
      @endforeach
    </tbody>
    </table>
</div>
<div class="financialist4">
    @if(sizeof($render))
      <a class="btn defaul  btn-default f_r" href="javascript:loadFlowConsumeLogSelectedPage('flow_red_consume_log?put_consume_start_time={{ $consumeStartTime }}&put_consume_end_time={{ $consumeEndTime }}&page=');" role="button">GO</a>
      <div class="input-wrap f_r">
          <input type="text" class="W-input " id="consume-page" value="" data-form-un="1460442869071.4133">
          <span class="holder-tip" style="display: inline;"></span>
      </div>
      <ul class="pagination f_r">
        <li @if($page==1)class="disabled" @endif>
          <a @if($page!=1) href="javascript:LoadConsumePage('flow_red_consume_log?put_consume_start_time={{ $consumeStartTime }}&put_consume_end_time={{ $consumeEndTime }}&page={{$page-1}}');"@endif aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        @foreach ($render as $r)
        <li class="  @if($r==$page) active @endif @if($r=='...') disabled @endif"><a @if($r!='...')href="javascript:LoadConsumePage('flow_red_consume_log?put_consume_start_time={{ $consumeStartTime }}&put_consume_end_time={{ $consumeEndTime }}&page={{$r}}');" @endif>{{$r}}</a></li>
        @endforeach
        <li @if($page==$render[sizeof($render)-1])class="disabled" @endif>
          <a @if($page!=$render[sizeof($render)-1]) href="javascript:LoadConsumePage('flow_red_consume_log?put_consume_start_time={{ $consumeStartTime }}&put_consume_end_time={{ $consumeEndTime }}&page={{$page+1}}');"@endif aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    @endif
  <span class="f_garycolor f_r">共有{{$totalCount}}条，每页显示：{{$page_size}}条</span>
  <div class="blank0"></div>
</div>
