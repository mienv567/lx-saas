<div class="financialist2">
  @if ($rechargeStartTime or $rechargeEndTime)
    @if ($rechargeStartTime)
      {{$rechargeStartTime}}
    @else
      不限
    @endif
    &nbsp;至&nbsp;
    @if ($rechargeEndTime)
      {{$rechargeEndTime}}
    @else
      不限
    @endif
    &nbsp;
  @endif充值总计：<em class="f_themecolor">￥{{ $totalRecharge }}</em>
</div>
<div class="financialist3">
    <table class="table table-hover">
    <thead>
        <tr>
          <th class="percent50">充值时间</th>
          <th class="percent30">金额</th>
          <th class="textcenter">充值来源</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($recharges as $recharge)
        <tr onclick="">
          <td>{{ $recharge->created_at }}</td>
          <td>￥{{ $recharge->amount }}</td>
          <td class="textcenter"><span class="f_greencolor">{{ $recharge->method }}</span></td>
        </tr>
    @endforeach
    </tbody>
    </table>
</div>
<div class="financialist4">
  @if ($recharges->hasMorePages() == 1 || $recharges->currentPage() != 1)
    <a class="btn defaul  btn-default f_r" href="javascript:loadRecharLogSelectedPage('financial_recharge_log?put_recharge_start_time={{ $rechargeStartTime }}&put_recharge_end_time={{ $rechargeEndTime }}&page=');" role="button">GO</a>
    <div class="input-wrap f_r">
        <input type="text" class="W-input " id="recharge-page" value="" data-form-un="1460442869071.4133">
        <span class="holder-tip" style="display: inline;"></span>
    </div>
  @endif
  <ul class="pagination f_r">
    {!! $recharges->render() !!}
  </ul>
  <span class="f_garycolor f_r">共有{{ $recharges->total() }}条，每页显示：{{ $recharges->perPage() }}条</span>
  <div class="blank0"></div>
</div>
