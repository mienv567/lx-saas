<script type="text/javascript">
function orderCancel(orderId,key) {
  $.ajax({
    url:"{{ url('user/financial_order_cancel') }}",
    type:"GET",
    data:{order_id:orderId},
    dataType: "json",
    success:function(data){
      if (data.errcode == 0) {
        var orderNo = data.orderNo;
        var content = '您的订单'+orderNo+'，已成功取消';
        alertSuccess(content);
        $('#order-status-'+key+' span').replaceWith('<span class="f_garycolor">已取消</span>');
        $('#order-deal-'+key).empty();
      } else if(data.errcode == 1002) {
        alertWarn(data.errmsg);
      }
    }
  })
}
  function abnormalOrderDeal(orderId){
    $.ajax({
      url:"{{ url('user/abnormal_order_deal') }}",
      type:"GET",
      data:{order_id:orderId},
      dataType: "json",
      success:function(data){
        if (data.errcode == 1002 || data.errcode == 1001) {
          alertWarn(data.errmsg);
        }
        if (data.errcode == 0) {
          alertConfirm('订单完成，产品生成成功',
          function(){
          location.reload();
          },
          {okButtonText: '确定', cancelButtonText: '取消'});
        }
      }
    })
  }
</script>
<div class="financialist3">
    <table class="table table-hover">
    <thead>
        <tr>
          <th>订单时间</th>
          <th>订单号</th>
          <th>订单内容</th>
          <th class="textright">订单金额</th>
          <th>已付金额</th>
          <th>订单状态</th>
          <th class="textright">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($orders as $key =>$order)
        <tr onclick="">
          <td>{{ $order->created_at }}</td>
          <td>{{ $order->order_no }}</td>
          <td>{{ $order->order_topic }}
          <a class="a-link" href="{{ url('user/financial_order_detail') }}?order_id={{$order->id}}">[详情]</a>
          </td>
          <td class="textright">￥{{ $order->order_money }}</td>
          <td >￥{{ $order->pay_money }}</td>
          <td id="order-status-{{ $key }}">
          @if($order->order_status == 0)
          <span class="f_bluecolor">待支付</span>
          @elseif($order->order_status == 1)
          <span class="f_redcolor">已支付，未处理</span>
          @elseif($order->order_status == 2)
          <span class="f_greencolor">已完成</span>
          @elseif($order->order_status == 3)
          <span class="f_redcolor">已支付，处理异常</span>
          @elseif($order->order_status == 4)
          <span class="f_garycolor">已取消</span>
          @endif
          </td>
          <td class="textright" id="order-deal-{{ $key }}">
          @if($order->order_status == 0)
          <a class="a-link" href="{{ url('user/financial_pay') }}?order_id={{$order->id}}">立即支付</a>
          <span class="line1"></span>
          <a class="a-linkred z-openmarker" href="javascript:alertConfirm(' 您真的要取消吗？',function(){
          orderCancel({{ $order->id }},{{ $key }});
          },{okButtonText: '确定', cancelButtonText: '取消'});">取消订单</a>
          @elseif($order->order_status == 3 or $order->order_status == 1)
          <a class="a-linkred z-openmarker" href="
          javascript:abnormalOrderDeal({{ $order->id }})">立即处理</a>
          @endif
          </td>
        </tr>
    @endforeach
    </tbody>
    </table>
</div>
<div class="financialist4">
@if ($orders->hasMorePages() == 1 || $orders->currentPage() != 1)
  <a class="btn defaul  btn-default f_r" href="javascript:loadOrderLogSelectedPage('financial_order_log?put_order_key={{ $orderKey }}&put_order_status={{ $orderStatus }}&put_order_start_time={{ $orderStartTime }}&put_order_end_time={{ $orderEndTime }}&page=');" role="button">GO</a>
  <div class="input-wrap f_r">
      <input type="text" class="W-input " id="order-page" value="" data-form-un="1460442869071.4133">
      <span class="holder-tip" style="display: inline;"></span>
  </div>
@endif
<ul class="pagination f_r">
  {!! $orders->render() !!}
</ul>
<span class="f_garycolor f_r">共有{{ $orders->total() }}条，每页显示：{{ $orders->perPage() }}条</span>
<div class="blank0"></div>
</div>
