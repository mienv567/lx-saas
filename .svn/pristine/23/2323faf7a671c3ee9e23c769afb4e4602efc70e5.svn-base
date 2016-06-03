<?php

namespace App\Http\Controllers\CloudService;
use App\Api\Product\SmsProductHandler;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CommonUtils;
use Illuminate\Http\Request;
use App\Facades\ArrayToObject;
use Auth,Validator;

/**
 * 流量红包控制器
 */

class SmsRechargeController extends Controller{

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    //列表
    public function index(Request $request){
        $all = $request->all();
        $user = Auth::user();
        $smsinfo = array();
        $smsinfo['act'] ='query';
        $smsinfo['appid'] = $user['app_id'];
        if(isset($all['user_start_time']) && trim($all['user_start_time'])!=''){
            $smsinfo['start_time'] = strtotime($all['user_start_time']);
        }
        if(isset($all['user_end_time']) && trim($all['user_end_time'])!=''){
            $smsinfo['end_time'] = strtotime($all['user_end_time']);
        }
        $page_size = 10;
        $page = $request->page;
        if(empty($page)){
            $page = 1;
        }
        //print_r($page);exit;
        if($page){
            $smsinfo['start_index'] = intval($page_size * ($page-1));
            $smsinfo['end_index'] = intval($page_size);
        }else{
            $smsinfo['start_index'] = 0;
            $smsinfo['end_index'] = intval($page_size);
        }
        ksort($smsinfo);
        $sign_str="";
        foreach($smsinfo as $k=>$v){
            $sign_str .= $k."|".$v;
        }
        $smsinfo['sign_str'] = md5($sign_str."KJHKJHKJN<MNMNBU&T*&^*&^*YIHKJHjk");
        $smsinfo = json_encode($smsinfo);

        $url = 'http://sms.fanwe.com/userpost';
        $common = new CommonUtils();
        $request = $common->curlRequest($url,$smsinfo);
        $request = json_decode($request,true);
        $sms_users = $request['data'];
        $totalCount = $request['totalCount'];
        $render = $this->get_pages($totalCount,$page_size,$page);
        $data = compact("sms_users","all","render","page","totalCount","page_size");
        //print_r($smsinfo);exit;
        return view('cloud_service.sms_user_index',$data);
    }

    public function actor(Request $request){
        $type = $request->type;
        return view('cloud_service.sms_user_add',compact("type"));
    }

    public function store(Request $request){
        $all = $request->all();
        $validator = Validator::make($all, [
            'user_name' => 'required',
            'user_pwd' => 'required|min:6|max:20',
            'product' => 'required',
            'sign' => 'required'
        ],[
            'user_name.required' => '必须填写账户名称',
            'user_pwd.required' => '必须填写密码',
            'user_pwd.min' => '密码至少6个字符',
            'user_pwd.max' => '密码最多20个字符',
            'product.required' => '必须填写产品',
            'sign.required' => '必须填写账户签名'
        ]);
        if ($validator->fails()) {
            return response()->json(
                array(
                    'status' => 0,
                    'msg' => $validator->getMessageBag()->first(),
                )
            );
        }
        $user = Auth::user();
        $smsinfo = array();
        $smsinfo['act'] = 'adduser';
        $smsinfo['user_name'] =trim($all['user_name']);
        $smsinfo['user_pwd'] = trim($all['user_pwd']);
        $smsinfo['sign'] = trim($all['sign']);
        $smsinfo['appid'] = $user->app_id;
        $smsinfo['product'] = trim($all['product']);
        ksort($smsinfo);
        $sign_str = "";
        foreach ($smsinfo as $k => $v) {
            $sign_str .= $k . "|" . $v;
        }
        $smsinfo['sign_str'] = md5($sign_str . "KJHKJHKJN<MNMNBU&T*&^*&^*YIHKJHjk");
        $smsinfo = json_encode($smsinfo);
        $url = 'http://sms.fanwe.com/userpost';
        $commonUtil = new CommonUtils();
        $result = $commonUtil->curlRequest($url, $smsinfo);
        $result = json_decode($result, true);
        return response()->json($result);
    }

    public function bind(Request $request){
        $all = $request->all();
        $validator = Validator::make($all, [
            'user_name' => 'required',
            'user_pwd' => 'required',
        ],[
            'user_name.required' => '必须填写账户名称',
            'user_pwd.required' => '必须填写密码',
        ]);
        if ($validator->fails()) {
            return response()->json(
                array(
                    'status' => 0,
                    'msg' => $validator->getMessageBag()->first(),
                )
            );
        }
        $user = Auth::user();
        $smsinfo = array();
        $smsinfo['act'] = 'binduser';
        $smsinfo['user_name'] =trim($all['user_name']);
        $smsinfo['user_pwd'] = trim($all['user_pwd']);
        $smsinfo['appid'] = $user->app_id;
        ksort($smsinfo);
        $sign_str = "";
        foreach ($smsinfo as $k => $v) {
            $sign_str .= $k . "|" . $v;
        }
        $smsinfo['sign_str'] = md5($sign_str . "KJHKJHKJN<MNMNBU&T*&^*&^*YIHKJHjk");
        $smsinfo = json_encode($smsinfo);
        $url = 'http://sms.fanwe.com/userpost';
        $commonUtil = new CommonUtils();
        $result = $commonUtil->curlRequest($url, $smsinfo);
        $result = json_decode($result, true);
        return response()->json($result);
    }

    public function edit(Request $request){
        $uid = intval($request->uid);
        $user = Auth::user();
        $smsinfo = array();
        $smsinfo['act'] = 'query';
        $smsinfo['id'] = intval($uid);
        $smsinfo['appid'] = $user->app_id;
        ksort($smsinfo);
        $sign_str = "";
        foreach ($smsinfo as $k => $v) {
            $sign_str .= $k . "|" . $v;
        }
        $smsinfo['sign_str'] = md5($sign_str . "KJHKJHKJN<MNMNBU&T*&^*&^*YIHKJHjk");
        $smsinfo = json_encode($smsinfo);
        $url = 'http://sms.fanwe.com/userpost';
        $commonUtil = new CommonUtils();
        $result = $commonUtil->curlRequest($url, $smsinfo);
        $result = json_decode($result, true);
        if(sizeof($result['data'])){
            $sms_user = $result['data'][0];
        }
        $data = compact("sms_user","uid");

        return view('cloud_service.sms_user_edit',$data);
    }

    public function update(Request $request){
        $all = $request->all();
        $validator = Validator::make($all, [
            'user_pwd' => 'min:6|max:20',
            'product' => 'required',
            'sign' => 'required'
        ],[
            //'user_pwd.required' => '必须填写密码',
            'user_pwd.min' => '密码至少6个字符',
            'user_pwd.max' => '密码最多20个字符',
            'product.required' => '必须填写产品',
            'sign.required' => '必须填写账户签名'
        ]);
        if ($validator->fails()) {
            return response()->json(
                array(
                    'status' => 0,
                    'msg' => $validator->getMessageBag()->first(),
                )
            );
        }
        $user = Auth::user();
        $smsinfo = array();
        $smsinfo['act'] = 'modifyuser';
        if(trim($all['user_pwd'])!=''){
            $smsinfo['user_pwd'] = trim($all['user_pwd']);
        }
        $sign = trim($all['sign']);
        $smsinfo['sign'] = $sign;
        $smsinfo['appid'] = $user->app_id;
        $smsinfo['product'] = trim($all['product']);
        $smsinfo['user_id'] = intval($all['id']);
        ksort($smsinfo);
        $sign_str = "";
        foreach ($smsinfo as $k => $v) {
            $sign_str .= $k . "|" . $v;
        }
        $smsinfo['sign_str'] = md5($sign_str . "KJHKJHKJN<MNMNBU&T*&^*&^*YIHKJHjk");
        $smsinfo = json_encode($smsinfo);
        $url = 'http://sms.fanwe.com/userpost';
        $commonUtil = new CommonUtils();
        $result = $commonUtil->curlRequest($url, $smsinfo);
        $result = json_decode($result, true);
        return response()->json($result);
    }

    public function recharge_index(Request $request){
        $uid = intval($request->uid);
        $user = Auth::user();
        $smsinfo = array();
        $smsinfo['act'] = 'query';
        $smsinfo['id'] = intval($uid);
        $smsinfo['appid'] = $user->app_id;
        ksort($smsinfo);
        $sign_str = "";
        foreach ($smsinfo as $k => $v) {
            $sign_str .= $k . "|" . $v;
        }
        $smsinfo['sign_str'] = md5($sign_str . "KJHKJHKJN<MNMNBU&T*&^*&^*YIHKJHjk");
        $smsinfo = json_encode($smsinfo);
        $url = 'http://sms.fanwe.com/userpost';
        $commonUtil = new CommonUtils();
        $result = $commonUtil->curlRequest($url, $smsinfo);
        $result = json_decode($result, true);
        if(sizeof($result['data'])){
            $sms_user = $result['data'][0];
        }
        $data = compact("sms_user","uid");
        return view('cloud_service.sms_recharge_index',$data);
    }

    //充值更新
    public function recharge(Request $request){

        $validator = Validator::make($request->all(), [
            'recharge_number' => 'required|sms_number',//
        ],[
            'recharge_number.required' => '必须填写充值数量',
            'recharge_number.sms_number' => '充值数量必须是5000的倍数',
        ]);
        if ($validator->fails()) {
            return response()->json(
                array(
                    'err' => 1,
                    'msg' => $validator->getMessageBag()->first(),
                )
            );
        }
        $smsNumber = intval($request->recharge_number);
        $money = $this->get_money($smsNumber);
        if($money == 0){
            return response()->json(
                array(
                    'err' => 1,
                    'msg' => '充值数量错误',
                )
            );
        }
        $orderTopic = '云服务-短信充值';
        $user_id = $request->user_id;
        $buyInfo = array('smsUserId'=>$user_id,'smsMoney'=>$money,'smsNumber'=>$smsNumber);
        $handle = new SmsProductHandler();
        $order = $handle->makeOrder(Auth::id(),$orderTopic,2,$money,$buyInfo);
        if($order){
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


    //充值明细
    public function rechargeLog(Request $request){
        // 设置默认变量
        $totalRecharge = 0;
        $rechargeStartTime = null;
        $rechargeEndTime = null;

        $user = $request->user();

        $rechargesQuery = $orders = Order::where('user_id',Auth::id())->where('product_type',0)->where('product_id',2)->whereIn('order_status',[1,2,3]);

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
        $uid = intval($request->uid);
        if($uid>0){
            $rechargesQuery = $rechargesQuery->where('buy_info', 'like','%:"'.$uid.'"%');
        }

        $allRecharges = $rechargesQuery->get();

        $recharges = $rechargesQuery->orderBy('created_at', 'desc')->paginate(10);
        foreach($recharges as $k=>$v){
            $buy_info = json_decode($v->buy_info,true);
            $recharges[$k]['sms_number'] = $buy_info['smsNumber'];
        }
        $recharges->setPath('javascript:loadSmsRecharLogPage(\'sms_recharge_log?uid='.$uid.'&put_recharge_start_time=' . $rechargeStartTime . '&put_recharge_end_time=' . $rechargeEndTime . '');
        $recharges->fragment('\');');

        if ($allRecharges->count() != 0) {
            foreach ($allRecharges as $recharge) {
                $totalRecharge += $recharge->order_money;
            }
        }

        return view('cloud_service.sms_recharge_log_page', [
            'rechargeStartTime' => $rechargeStartTime,
            'rechargeEndTime' => $rechargeEndTime,
            'recharges' => $recharges,
            'totalRecharge' => $totalRecharge,
            'uid' => $uid
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

        $uid = intval($request->uid);
        $user = Auth::user();
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
        $smsinfo['appid'] = $user->app_id;
        $smsinfo['user_id'] = $uid;
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
        ksort($smsinfo);
        $sign_str="";
        foreach($smsinfo as $k=>$v){
            $sign_str .= $k."|".$v;
        }
        $smsinfo['sign_str'] = md5($sign_str."KJHKJHKJN<MNMNBU&T*&^*&^*YIHKJHjk");
        $smsinfo = json_encode($smsinfo);
        $url = 'http://sms.fanwe.com/userpost';
        $common = new CommonUtils();
        $result = $common->curlRequest($url,$smsinfo);
        $result = json_decode($result,true);

        $totalCount = $result['totalCount'];
        $consumes =  $result['data'];
        if (sizeof($consumes)) {
            foreach ($consumes as $k=>$v) {
                $totalConsume += $v['all_count'];
            }
        }
        $consumes = new ArrayToObject($consumes);

        $consumes->setPath('javascript:loadSmsConsumeLogPage(\'sms_consume_log?put_consume_start_time=' . $consumeStartTime . '&put_consume_end_time=' . $consumeEndTime);
        //$consumes->fragment('\');');

        //分页
        $render = $this->get_pages($totalCount,$page_size,$page);

        return view('cloud_service.sms_consume_log_page', [
            'consumeStartTime' => $consumeStartTime,
            'consumeEndTime' => $consumeEndTime,
            'consumes' => $consumes,
            'totalConsume' => $totalConsume,
            'totalCount'=>$totalCount,
            'page_size' =>$page_size,
            'render' =>$render,
            'page' =>$page,
            'uid' => $uid
        ]);
    }

    //获取分页
    public function get_pages($totalCount,$page_size,$page){
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
        return $render;
    }

    //根据短信数量计算需充值的金额
    public function get_money($sms_number){
        if($sms_number>=5000 && $sms_number<15000){
            return $sms_number * 0.080;
        }elseif($sms_number>=15000 && $sms_number<35000){
            return $sms_number * 0.075;
        }elseif($sms_number>=35000 && $sms_number<50000){
            return $sms_number * 0.070;
        }elseif($sms_number>=50000){
            return $sms_number * 0.065;
        }else{
            return 0;
        }
    }

}