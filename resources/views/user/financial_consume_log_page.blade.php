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
          <th>支付方式</th>
          <th class="textright">消费金额</th>
          <th class="textright">订单号</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($consumes as $consume)
        <tr onclick="">
          <td>{{ $consume->created_at }}</td>
          <td>{{ $consume->method }}</td>
          <td class="textright">{{ $consume->amount }}</td>
          <td class="textright">{{ $consume->order->order_no }}</td>
        </tr>
      @endforeach
    </tbody>
    </table>
</div>
<div class="financialist4">
  @if ($consumes->hasMorePages() == 1 || $consumes->currentPage() != 1)
    <a class="btn defaul  btn-default f_r" href="javascript:loadConsumeLogSelectedPage('financial_consume_log?put_consume_status={{ $consumeStatus }}&put_consume_start_time={{ $consumeStartTime }}&put_consume_end_time={{ $consumeEndTime }}&page=');" role="button">GO</a>
      <div class="input-wrap f_r">
          <input type="text" class="W-input " id="consume-page" value="" data-form-un="1460442869071.4133">
          <span class="holder-tip" style="display: inline;"></span>
      </div>
  @endif
  <ul class="pagination f_r">
    {!! $consumes->render() !!}
  </ul>
  <span class="f_garycolor f_r">共有{{ $consumes->total() }}条，每页显示：{{ $consumes->perPage() }}条</span>
  <div class="blank0"></div>
</div>
