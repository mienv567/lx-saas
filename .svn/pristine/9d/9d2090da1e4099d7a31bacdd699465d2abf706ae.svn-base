<?php

namespace App\Http\Controllers\CloudService;
use App\Api\Product\FlowGiftProductHandler;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Facades\ArrayToObject;
use Auth,Validator;

/**
 * 流量红包控制器
 */

class FlowRedController extends Controller{

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    //列表
    public function index(Request $request){


        $result = $this->get_flow_red();
        $flow_red = $result['data'];
        $data = compact("flow_red");
        return view('cloud_service.flow_red_index',$data);
    }

    //充值明细
    public function rechargeLog(Request $request){
        // 设置默认变量
        $totalRecharge = 0;
        $rechargeStartTime = null;
        $rechargeEndTime = null;

        $user = $request->user();

        $rechargesQuery = $orders = Order::where('user_id',Auth::id())->where('product_type',0)->where('product_id',1)->whereIn('order_status',[1,2,3]);

        if (isset($request->put_recharge_start_time)) {
            if (!empty($request->put_recharge_start_time)) {
                $rechargeStartTime = $request->put_recharge_start_time;
                $rechargesQuery = $rechargesQuery->where('created_at', '>=', $rechargeStartTime);
            }
        } elseif (!empty($request->recharge_start_time)) {
            $rechargeStartTime = $request->recharge_start_time;
            $rechargesQuery = $rechargesQuery->where('created_at', '>=', $rechargeStartTime);
        }

        if (isset($request->put_recharge_end_time)) {
            if (!empty($request->put_recharge_end_time)) {
                $rechargeEndTime = $request->put_recharge_end_time;
                $rechargesQuery = $rechargesQuery->where('created_at', '<=', $rechargeEndTime . ' 23:59:59');
            }
        } elseif (!empty($request->recharge_end_time)) {
            $rechargeEndTime = $request->recharge_end_time;
            $rechargesQuery = $rechargesQuery->where('created_at', '<=', $rechargeEndTime . ' 23:59:59');
        }

        $allRecharges = $rechargesQuery->get();

        $recharges = $rechargesQuery->orderBy('created_at', 'desc')->paginate(10);

        $recharges->setPath('javascript:loadFlowRecharLogPage(\'flow_red_recharge_log?put_recharge_start_time=' . $rechargeStartTime . '&put_recharge_end_time=' . $rechargeEndTime . '');
        $recharges->fragment('\');');

        if ($allRecharges->count() != 0) {
            foreach ($allRecharges as $recharge) {
                $totalRecharge += $recharge->order_money;
            }
        }

        return view('cloud_service.flow_red_recharge_log_page', [
            'rechargeStartTime' => $rechargeStartTime,
            'rechargeEndTime' => $rechargeEndTime,
            'recharges' => $recharges,
            'totalRecharge' => $totalRecharge,
        ]);
    }

    //消费明细
    public function consumeLog(Request $request){
        // 设置默认变量
        $totalConsume = 0;
        $consumeStartTime = null;
        $consumeEndTime = null;
        $totalCount = 0;
        $page_size = 10;

        $user = $request->user();
        $page = $request->page;
        if(empty($page)){
            $page = 1;
        }
        if($page){
            $smsinfo['start_index'] = intval($page_size * ($page-1));
            $smsinfo['end_index'] = intval($page_size);
        }else{
            $smsinfo['start_index'] = 0;
            $smsinfo['end_index'] = intval($page_size);
        }
        $smsinfo['act'] ='query';
        $smsinfo['appid'] = $user['app_id'];
        $smsinfo['appsecret'] = $user['app_password'];
        $smsinfo['table_name'] = 'user_send_log';
        if (isset($request->put_consume_start_time)) {
            if (!empty($request->put_consume_start_time)) {
                $consumeStartTime = $request->put_consume_start_time;
                $smsinfo['start_time'] = strtotime($consumeStartTime);
            }

        } elseif (!empty($request->consume_start_time)) {
            $consumeStartTime = $request->consume_start_time;
            $smsinfo['start_time'] = strtotime($consumeStartTime);
        }

        if (isset($request->put_consume_end_time)) {
            if (!empty($request->put_consume_end_time)) {
                $consumeEndTime = $request->put_consume_end_time;
                $smsinfo['end_time'] = strtotime($consumeEndTime);
            }
        } elseif (!empty($request->consume_end_time)) {
            $consumeEndTime = $request->consume_end_time;
            $smsinfo['end_time'] = strtotime($consumeEndTime);
        }
        $smsinfo = json_encode($smsinfo);
        $url = 'http://www.niuhudong.cn/userpost.php?server_string='.$smsinfo;
        $result = file_get_contents($url);
        $result = json_decode($result,true);
        $totalCount = $result['totalCount'];
        $consumes =  $result['data'];
        if (sizeof($consumes)) {
            foreach ($consumes as $k=>$v) {
                $totalConsume += $v['fee'];
                $consumes[$k]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
            }
        }
        $consumes = new ArrayToObject($consumes);

        $consumes->setPath('javascript:loadFlowConsumeLogPage(\'flow_red_consume_log?put_consume_start_time=' . $consumeStartTime . '&put_consume_end_time=' . $consumeEndTime);
        //$consumes->fragment('\');');

        //分页
        $render = array();
        if($totalCount>$page_size){
            $totalpage = ceil($totalCount/$page_size);
            if($totalpage<=11){
                for($i=0;$i<$totalpage;$i++){
                    $render[$i] = $i+1;
                }
            }else{
                if($page<=6){
                    for($i=0;$i<8;$i++){
                        $render[$i] = $i+1;
                    }
                    $render[8] = '...';
                    $render[9] = $totalpage-1;
                    $render[10] = $totalpage;
                }elseif($totalpage-$page<6){
                    $render[0] = 1;
                    $render[1] = 2;
                    $render[2] = '...';
                    $index = 8;
                    for($i=3;$i<12;$i++){
                        $render[$i] = $totalpage - $index;
                        $index--;
                    }
                }elseif($totalpage-$page>=6){
                    $render[0] = 1;
                    $render[1] = 2;
                    $render[2] = '...';
                    $index = 3;
                    for($i=3;$i<10;$i++){
                        $render[$i] = $page - $index;
                        $index--;
                    }
                    $render[10] = '...';
                    $render[11] = $totalpage-1;
                    $render[12] = $totalpage;
                }
            }
        }

        return view('cloud_service.flow_red_consume_log_page', [
            'consumeStartTime' => $consumeStartTime,
            'consumeEndTime' => $consumeEndTime,
            'consumes' => $consumes,
            'totalConsume' => $totalConsume,
            'totalCount'=>$totalCount,
            'page_size' =>$page_size,
            'render' =>$render,
            'page' =>$page
        ]);
    }

    //充值
    public function recharge(){

        $result = $this->get_flow_red();
        $flow_red = $result['data'];
        $data = compact("flow_red");
        return view('cloud_service.flow_red_recharge',$data);
    }

    //充值更新
    public function recharge_update(Request $request){

        $validator = Validator::make($request->all(), [
            'recharge_money' => 'required|min:0.01|flow_money',
        ],[
            'recharge_money.required' => '必须填写充值金额',
            'recharge_money.flow_money' => '充值金额必须是100的倍数',
            'recharge_money.min' => '充值金额必须大于0',
        ]);
        if ($validator->fails()) {
            return response()->json(
                array(
                    'err' => 1,
                    'msg' => $validator->getMessageBag()->first(),
                )
            );
        }

        $money = floatval($request->recharge_money);
        $orderTopic = '云服务-流量红包充值';
        $buyInfo = array('flowMoney'=>$money);
        $handle = new FlowGiftProductHandler();
        $order = $handle->makeOrder(Auth::id(),$orderTopic,1,$money,$buyInfo);
        if($order){
            //$result = $handle->makeOrderProduct($order['id']);
            return response()->json(
                array(
                    'err' => 0,
                    'url' => url('user/financial_pay?order_id='.$order['id']),
                )
            );

        }else{
            return response()->json(
                array(
                    'err' => 1,
                    'msg' => '充值失败',
                )
            );
        }
    }

    //获取用户流量红包信息
    public function get_flow_red(){
        $user = Auth::user();
        $smsinfo['act'] ='query';
        $smsinfo['appid'] = $user['app_id'];
        $smsinfo['appsecret'] = $user['app_password'];
        $smsinfo = json_encode($smsinfo);
        $curlPost = 'server_string='.$smsinfo;
        $url = 'http://www.niuhudong.cn/userpost.php';
        $ch = curl_init();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ($ch,  CURLOPT_RETURNTRANSFER,1);
        curl_setopt ( $ch, CURLOPT_POST, 1 ); //启用POST提交
        curl_setopt ($ch,CURLOPT_POSTFIELDS,$curlPost);
        $result = curl_exec ($ch);
        curl_close($ch);
        $result = json_decode($result,true);
        return $result;
    }

}