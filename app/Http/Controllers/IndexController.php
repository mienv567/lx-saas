<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Appsys;
use DB;

class IndexController extends Controller
{

    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct()
    {
        ini_set("display_errors", 1);
        error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);

        define('DB_PREFIX','saas_');

        $this->middleware('auth');
    }

    /**
     * 显示主页面
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 获取用户信息
        $user = $request->user();
        // 获取站内消息数
        $messageCount = Message::where('user_id', $user->id)->where('msgtype', 0)->count();
        // 获取站内消息列表
        $messages = Message::where('user_id', $user->id)->where('msgtype', 0)->take(5)->get();
        // 获取公告列表
        $bulletins = Message::where('msgtype', 1)->take(5)->get();
        //获取应用列表
        $appsys =Appsys::where('sale_visible', '<>', 0)->wherein('deploy_position',[0,1])->get();
        //公众号

        $weixin_conf_obj = DB::select("select * from ".DB_PREFIX."weixin_conf");
        $weixin_conf = array();
        foreach($weixin_conf_obj as $k=>$v){
            $weixin_conf[$v->name]=$v->value;
        }
        $account_obj = DB::table(DB_PREFIX."weixin_account")->where('appid',$user['app_id'])->first();
        $account = (array)$account_obj;

        // 显示
        $data = array('user'=>$user, 'messageCount'=>$messageCount, 'messages'=>$messages, 'bulletins'=>$bulletins,'appsys'=>$appsys,'account'=> $account);

        //未授权或者错误
        if($weixin_conf['platform_component_verify_ticket']&&!$account){
            $client = new \SAASAPIClient($user['app_id'], $user['app_secret']);
            $args = array('status'=>1);
            $ret = $client->invoke('http://service.yun.fanwe.com/weixin/return_ticket', $args);
            if($ret['errcode']>0){
                $error = $ret['errmsg'];
            }else{
                if($ret['data']['sq_url']){
                    $data['sq_url'] = $ret['data']['sq_url'];
                }
            }

        }else{
            $error="未获取 component_verify_ticket";
        }
        $data['error'] = $error;
        if($weixin_conf['platform_appid']&&$weixin_conf['authorizer_appid']&&!$account['user_name']){
            $client = new \SAASAPIClient($user['app_id'], $user['app_secret']);
            $args = array();
            $ret = $client->invoke('http://service.yun.fanwe.com/weixin/return_ticket', $args);
        }

        return view('index', $data);
    }

    /**
     * 显示主页面中的首页
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
        return view('home');
    }

}
