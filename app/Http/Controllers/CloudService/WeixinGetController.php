<?php

namespace App\Http\Controllers\CloudService;

use App\Saas\SAASAPIClient;
use App\Api\Weixin;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
//use App\Api;

/**
 * 云服务模块首页控制器类
 */
class WeixinGetController extends Controller
{
    public function __construct()
    {
        ini_set("display_errors", 1);
        error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);


        define('DB_PREFIX','saas_');

        define('APP_ROOT_PATH', str_replace('app/Http/Controllers/CloudService/WeixinGetController.php', '', str_replace('\\', '/', __FILE__)));

    }
    public function create_url(Request $request)
    {

        $user = Auth::user();
        $account_obj = DB::table(DB_PREFIX."weixin_account")->where('user_id',$user['id'])->first();

        $account = (array)$account_obj;
       // var_dump($account);exit;
        if($_REQUEST['code']&&$_REQUEST['state']==1){
            $from_url = urldecode($_REQUEST['from']);
            $weixin= new Weixin($account['authorizer_appid'],'','');

            $wx_info=$weixin->scope_get_userinfo($_REQUEST['code'],$_REQUEST['appid']);
           // var_dump($_GET);
          //  var_dump($wx_info);
            if($wx_info['openid']){
                $wx_info['authorizer_access_token'] = $account['authorizer_access_token'];
                $wx_info['authorizer_appid'] = $account['authorizer_appid'];
                    //  var_dump($wx_info);

//                $ch = curl_init();
//
//                $data = array('name' => 'Foo', 'age' => 25);
//
//                curl_setopt($ch, CURLOPT_URL, $from_url);
//                curl_setopt($ch, CURLOPT_POST, 1);
//                curl_setopt($ch, CURLOPT_POSTFIELDS, $wx_info);
//              $new_str = '';
                /*$from_url_str = '';
                foreach($wx_info as $k=>$v){
                    if($v){
                        $from_url_str .= $k."=".$v."&";
                    }
                }*/
//                curl_exec($ch);
                //加密
                $appid = 'fw9ae7883339a8a55f';
                $appsecret = '5cce8819673f948c40e60fcade608dbb';
                $client = new SAASAPIClient($appid, $appsecret);

                // 生成方维系统间信息安全传递地址
                $widthAppid = true;  // 生成的安全地址是否附带appid参数
                $timeoutMinutes = 10; // 安全参数过期时间（单位：分钟），小于等于0表示永不过期
                $url = $client->makeSecurityUrl($from_url, $wx_info, $widthAppid, $timeoutMinutes);

                header("Location:".$url);

                //header("Location:".$from_url."?".$from_url_str);

            }else{
               echo "未获取用户授权";
            }
        }else{
            $from_url = urlencode($_REQUEST['from']);
            $weixin= new Weixin($account['authorizer_appid'],'','http://yun.fanwe.com/cloud_service/weixin_create_url?from='.$from_url);
            $wx_url=$weixin->scope_get_code($account['authorizer_appid']);
            header("Location:".$wx_url);
        }

    }

    public function jump_url(){

    }


}
