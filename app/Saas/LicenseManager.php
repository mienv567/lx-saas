<?php

namespace App\Saas;

require_once(__DIR__.'/SAASAPIClient.php');

use DB;
use Log;
use App\Models\User;
use App\Models\Appsys;
use App\Models\AppsysLicense;
use App\Models\AppsysLicenseDomain;
use App\Models\AppsysWeixinTemplate;
use App\Models\WeixinAccount;
use \SAASAPIClient;
use Illuminate\Container\Container;
use Illuminate\Database\Connectors\ConnectionFactory;

const FANWE_DOMAIN_SUFFIX     = '.fanwe.com';          // 方维基础域名
const VARNAME_SAAS_ENV        = '_FANWE_SAAS_ENV';     // SAAS系统环境变量变量名
const VARNAME_APPSYS_ID       = 'APPSYS_ID';           // 环境变量中应用系统标识号（即系统短名称，如：o2o，p2p等）
const VARNAME_APPSYS_PACKAGE  = 'APPSYS_PACKAGE';      // 环境变量中应用系统套餐号变量名
const VARNAME_SAAS_APP_ID     = 'APP_ID';              // 环境变量中应用开发APPID变量名
const VARNAME_SAAS_APP_SECRET = 'APP_SECRET';          // 环境变量中应用开发APP密钥变量名

/* 包含授验证代码的字符串常量定义 */
const LICENSE_AUTH_CODE = <<<EOD
    date_default_timezone_set('Asia/Shanghai');
    \$_fanwe_saas_auth_domain_errmsg  = "The domain not authorized!";
    \$_fanwe_saas_auth_expire_errmsg  = "License has expired!";
    \$_fanwe_saas_auth_host = \$_SERVER["HTTP_HOST"];
    \$_fanwe_saas_auth_host = explode(":",\$_fanwe_saas_auth_host);
    \$_fanwe_saas_auth_host = \$_fanwe_saas_auth_host[0];
    \$_fanwe_saas_auth_bln = false;
    foreach (\$_fanwe_saas_auth_domains as \$_fanwe_saas_auth_domain) {
        if (substr(\$_fanwe_saas_auth_domain,0,2) === "*.") {
            if (preg_match("/".preg_quote(substr(\$_fanwe_saas_auth_domain, 2))."$/", \$_fanwe_saas_auth_host) > 0) {
                \$_fanwe_saas_auth_bln = true;
                break;
            }
        }
    }
    if (!\$_fanwe_saas_auth_bln && !in_array(\$_fanwe_saas_auth_host, \$_fanwe_saas_auth_domains) && !preg_match("/192.168.\d+.\d+/i", \$_fanwe_saas_auth_host) && !preg_match("/localhost/i", \$_fanwe_saas_auth_host) && !preg_match("/127.0.0.1/i", \$_fanwe_saas_auth_host)) {
        echo \$_fanwe_saas_auth_domain_errmsg;
        exit;
    };
    if (!empty(\$_fanwe_saas_auth_expire) && \$_fanwe_saas_auth_expire > 0 && \$_fanwe_saas_auth_expire < time()) {
        echo \$_fanwe_saas_auth_expire_errmsg;
        exit;
    }
EOD;

/**
 *
 * 方维SAAS系统授权信息管理类，提供生成授权、更新指定域名服务器上授权信息等功能。
 *
 */
class LicenseManager
{

    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct()
    {
        date_default_timezone_set('Asia/Shanghai');
    }

    /**
     * 生成授权文件，并保存更新到数据库中，同时将最新的授权文件信息更新至部署在方维应用服务器中的相应的应用系统。
     *
     * @param $userId 授权客户ID
     * @param $appsysId 授权应用系统ID
     * @param $licenseInfo 授权信息，数组对象，定义：["domains"=>["xxx.yydb.fanwe.com"],"func_package"=>"standard","expire_time"=>"2050-01-01 00:00:00"]
     * @param $coreConfigInfo 应用系统核心配置信息，数组对象，定义：["db_host"=>"172.0.0.1","db_port"=>"3306",...]
     * @param $deployInSaas 是否部署在saas平台，如果部署在saas平台，那么将进行自动创建数据库、自动分配子域名等操作
     * @param $replaceIfExists 当指定用户已授权了指定应用系统时，是否覆盖替换，默认否
     * @return 生成结果，数组对象，如：array("errcode"=>0,"errmsg"=>"","data"=>array("faildomains"=>[]))，如果有域名服务器上的授权更新失败，
     *         那么errcode照样返回成功，只是data->faildomains中将保存授权更新失败的域名列表
     */
    public function createLicense($userId, $appsysId, array $licenseInfo, array $coreConfigInfo, $deployInSaas = false, $replaceIfExists = false)
    {
        // 初始化定义
        $errcode = 0;
        $errmsg = '';
        $data = array();
        
        // 参数校验
        if (empty($userId) || !is_numeric($userId)) {
            return array('errcode'=>1002,'errmsg'=>'userId参数无效！');
        }
        if (empty($appsysId) || !is_numeric($appsysId)) {
            return array('errcode'=>1002,'errmsg'=>'appsysId参数无效！');
        }
        if (empty($licenseInfo) && !$deployInSaas) {
            return array('errcode'=>1002,'errmsg'=>'licenseInfo参数不能为空！');
        }
        
        // 解析授权信息并验证，同时去除授权域名前后空格
        $domains = array_key_exists('domains', $licenseInfo) ? $licenseInfo['domains'] : array();
        $funcPackage = array_key_exists('func_package', $licenseInfo) ? $licenseInfo['func_package'] : '';
        $expireTime = array_key_exists('expire_time', $licenseInfo) ? $licenseInfo['expire_time'] : '';
        if (empty($domains) && !$deployInSaas) {
            return array('errcode'=>1002,'errmsg'=>'licenseInfo参数中必须存在domains变量！');
        }
        $count = count($domains);
        for ($i = 0; $i < $count; $i++) {
            $domains[$i] = trim($domains[$i]);
        }
        
        // 获取授权用户信息
        $user = User::find($userId);
        if (empty($user)) {
            return array('errcode'=>2001,'errmsg'=>'授权用户不存在！');
        }
        
        // 获取授权应用系统信息
        $appsys = Appsys::find($appsysId);
        if (empty($appsys)) {
            return array('errcode'=>2002,'errmsg'=>'授权应用系统不存在！');
        }
        
        // 自动创建数据库、自动分配子域名
        if ($deployInSaas) {
            // 自动创建数据库
            $buildConfig = empty($appsys->build_config) ? array() : (Array)json_decode($appsys->build_config);
            if (!array_key_exists('db', $buildConfig)) {
                return array('errcode'=>2007,'errmsg'=>'云平台上的应用系统必须配置“自动构建信息”！');
            }
            $buildDBConfig = $buildConfig['db'];
            $dbConfig = array();
            if (count($buildDBConfig) > 0) {
                if (array_key_exists(0, $buildDBConfig)) { // 是个数组列表，随机获取一个
                    $count = count($buildDBConfig);
                    $dbConfig = (Array)$buildDBConfig[mt_rand(0,$count-1)];
                } else { // 单个配置
                    $dbConfig = (Array)$buildDBConfig;
                }
            } else {
                return array('errcode'=>2007,'errmsg'=>'云平台上的应用系统必须配置“自动构建信息”！');
            }
            $dbHost = array_key_exists('host', $dbConfig) ? $dbConfig['host'] : '';
            $dbPort = array_key_exists('port', $dbConfig) ? $dbConfig['port'] : 3306;
            $dbAdminUser = array_key_exists('admin_user', $dbConfig) ? $dbConfig['admin_user'] : '';
            $dbAdminPass = array_key_exists('admin_pass', $dbConfig) ? $dbConfig['admin_pass'] : '';
            $dbNamePrefix = array_key_exists('name_prefix', $dbConfig) ? $dbConfig['name_prefix'] : '';
            $dbName = 'saas_'.$dbNamePrefix.$user->id;
            $dbUser = 'saas_'.$dbNamePrefix.$user->id;
            $dbPass = $user->app_secret;
            $ret = $this->createAppsysMysqlDB($dbHost, $dbPort, $dbAdminUser, $dbAdminPass, $dbName, $dbUser, $dbPass);
            // 设置配置环境变量
            $configEnv = [
                '$SAAS_USED_DB_HOST'       => $dbHost,
                '$SAAS_USED_DB_POST'       => $dbPort,
                '$SAAS_USED_DB_ADMIN_USER' => $dbAdminUser,
                '$SAAS_USED_DB_ADMIN_PASS' => $dbAdminPass,
                '$SAAS_USED_DB_NAME'       => $dbName,
                '$SAAS_USED_DB_USER'       => $dbUser,
                '$SAAS_USED_DB_PASS'       => $dbPass,
                '$SAAS_USER_ID'            => $user->id,
                '$SAAS_USER_USERNAME'      => $user->username,
                '$SAAS_USER_PASSWORD'      => $user->password,
                '$SAAS_USER_APP_ID'        => $user->app_id,
                '$SAAS_USER_APP_SECRET'    => $user->app_secret,
                '$SAAS_USER_APP_PASSWORD'  => $user->app_password,
            ];
            // 修改应用系统核心配置项中的环境变量值
            $coreConfigItemJson = '';
            if (!empty($appsys->core_config_item)) {
                $coreConfigItemJson = $appsys->core_config_item;
                foreach ($configEnv as $key=>$value) {
                    $coreConfigItemJson = str_replace(''.$key, ''.$value, $coreConfigItemJson);
                }
            }
            // 修改核心配置信息为自动创建的信息
            $coreConfigInfo = array();
            $coreConfigItems = empty($coreConfigItemJson) ? array() : (Array)json_decode($coreConfigItemJson);
            foreach ($coreConfigItems as $coreConfigItem) {
                $coreConfigItem = (Array)$coreConfigItem;
                $key = array_key_exists('name', $coreConfigItem) ? $coreConfigItem['name'] : '';
                $value = array_key_exists('autoBuildValue', $coreConfigItem) ? $coreConfigItem['autoBuildValue'] : '';
                if (!empty($key)) {
                    $coreConfigInfo[$key] = $value;
                }
            }
            // 添加授权域名（saas平台中的子域名）
            if (!empty($appsys->main_domain)) {
                $domain = ($user->id).'.'.$appsys->main_domain;
                $domains[] = $domain;
            }
        }
        // 过滤重复和无效域名
        $fixedDomains = array();
        foreach ($domains as $domain) {
            $domain =  trim($domain);
            if (empty($domain) || in_array($domain, $fixedDomains, true)) {
                continue;
            }
            $fixedDomains[] = $domain;
        }
        
        // 生成授权文件信息
        $licenseContent = $this->makeLicenseContent($user, $appsys, $fixedDomains, $expireTime, $funcPackage, $coreConfigInfo);
        
        // 授权信息入库
        $ret = $this->saveLicenseToDB($userId, $appsysId, $fixedDomains, $expireTime, $funcPackage, $coreConfigInfo, $licenseContent, $deployInSaas, $replaceIfExists);
        if ($ret['errcode'] != 0) {
            return $ret;
        } else {
            $data['licenseid'] = $ret['data']['licenseid'];
        }
        
        // 更新部署在方维服务器上的应用系统的授权信息
        if ($deployInSaas) {
            $ret = $this->updateLicenseToManyAppsys($user, $appsys->update_license_uri, $appsys->main_domain, $fixedDomains, $licenseContent);
            if ($ret['errcode'] != 0 && !empty($ret['data'])) {
                $data['faildomains'] = $ret['data']['faildomains'];
            }
        }
        
        // 返回结果
        return array('errcode'=>$errcode,'errmsg'=>$errmsg,'data'=>$data);
    }
    
    /**
     * 重新生成指定授权信息ID的授权内容，当授权应用信息核心代码有更新或用户APP密钥有更新时，可以调用此接口重新生成授权内容
     * @param $licenseId 待重新生成授权的授权信息ID
     * @return 生成结果，数组对象，如：array("errcode"=>0,"errmsg"=>"","data"=>array("faildomains"=>[]))，如果有域名服务器上的授权更新失败，
     *         那么errcode照样返回成功，只是data->faildomains中将保存授权更新失败的域名列表
     */
    public function recreateLicense($licenseId)
    {
        try {
            // 获取已有授权信息
            $license = AppsysLicense::find($licenseId);
            if (empty($license)) {
                return array(
                    'errcode' => 2006,
                    'errmsg' => '授权信息不存在！'
                );
            }
            // 获取授权用户信息
            $user = User::find($license->user_id);
            if (empty($user)) {
                return array(
                    'errcode' => 2001,
                    'errmsg' => '授权用户不存在！'
                );
            }
            // 获取授权应用信息
            $appsys = Appsys::find($license->appsys_id);
            if (empty($appsys)) {
                return array(
                    'errcode' => 2002,
                    'errmsg' => '授权应用系统不存在！'
                );
            }
            // 获取授权域名信息
            $licenseDomains = AppsysLicenseDomain::where('appsys_license_id', $license->id)->get();
            $domains = array();
            if (!empty($licenseDomains)) {
                foreach ($licenseDomains as $licenseDomain) {
                    $domains[] = $licenseDomain->domain;
                }
            }
            // 生成新授权文件内容
            $expireTime = $license->expire_time;
            $funcPackage = $license->appsys_func_package;
            $coreConfigInfo = empty($license->appsys_core_config) ? array() : json_decode($license->appsys_core_config, true);
            $licenseContent = $this->makeLicenseContent($user, $appsys, $domains, $expireTime, $funcPackage, $coreConfigInfo);
            // 更新授权内容到数据库中
            $license->license_info = $licenseContent;
            $license->save();
            // 更新已授权应用服务器上的授权文件
            $data = array();
            if ($license->deploy_in_saas != 0) {
                $ret = $this->updateLicenseToManyAppsys($user, $appsys->update_license_uri, $appsys->main_domain, $domains, $licenseContent);
                if ($ret['errcode'] != 0 && !empty($ret['data'])) {
                    $data['faildomains'] = $ret['data']['faildomains'];
                }
            }
            // 返回结果
            return array('errcode'=>0,'errmsg'=>'','data'=>$data);
        } catch (\Exception $e) {
            return array('errcode'=>1001,'errmsg'=>$e->getMessage());
        }
    }
    
    /**
     * 通过域名获取关联的授权信息。
     *
     * @param $domain 待获取关联授权的域名
     * @return 获取结果，数组对象，如：array("errcode"=>0,"errmsg"=>"","data"=>{})，获取成功时，data中将包含授权信息，
     *         对应数据库中表saas_appsys_license信息，信息中的license_info即为授权文件内容。同时也包含匹配到的域名信息，
     *         保存在data->domain中。
     */
    public function getLicenseByDomain($domain)
    {
        // 从应用系统授权域名信息表中查找信息
        $licenseDomains = $this->getLicenseDomainInfo($domain);
        if (empty($licenseDomains)) {
            return array('errcode'=>2004,'errmsg'=>'该域名还未授权！');
        }
        // 查找域名关联的授权信息
        $license = AppsysLicense::find($licenseDomains->appsys_license_id);
        $license->domain = $licenseDomains->domain;
        if (empty($license)) {
            return array('errcode'=>2004,'errmsg'=>'该域名还未授权！');
        } else {
            return array('errcode'=>0,'errmsg'=>'','data'=>$license);
        }
    }
    
    /**
     * 根据应用开发的AppID获取对应的App密钥。
     *
     * @param $appid 应用开发的AppID
     * @return 获取结果，数组对象，如：array("errcode"=>0,"errmsg"=>"","data"=>{})，获取成功时，data中将包含对应的App密钥。
     */
    public function getAppSecret($appid)
    {
        // 从应用系统授权域名信息表中查找信息
        $user = User::where('app_id', $appid)->first();
        if (empty($user)) {
            return array('errcode'=>1005,'errmsg'=>'appid无效！');
        }
        // 返回结果
        return array('errcode'=>0,'errmsg'=>'','data'=>$user->app_secret);
    }
    
    /**
     * 更新部署在指定几个域名服务器上的应用系统授权信息，更新时会判断域名是为方维子域名，非方维子域名的将被忽略
     *
     * @param $user 域名所属客户信息，其中包含AppID和App密钥
     * @param $updateUri 应用系统中执行域名更新服务的URI地址
     * @param $mainDomain 应用系统主域名
     * @param $domains 指定几个域名服务器的域名列表，数组对象
     * @param $licenseContent 用于更新的授权信息内容
     * @return 更新结果，数组对象，如：array("errcode"=>0,"errmsg"=>"","data"=>array("faildomains"=>[]))，错误码定义：
     *         0    - 更新成功;
     *         3001 - 有域名授权更新失败，此时data->faildomains中将保存授权更新失败的域名列表
     */
    public function updateLicenseToManyAppsys($user, $updateUri, $mainDomain, $domains, $licenseContent)
    {
        // 初始化定义
        $errcode = 0;
        $errmsg = '';
        $faildomains = array();
        // 循环更新各域名服务器上的授权
        if (!empty($domains) && !empty($mainDomain)) {
            $client = new SAASAPIClient($user->app_id, $user->app_secret);
            foreach ($domains as $domain) {
                if ($this->strEndWidth($domain, $mainDomain)) { // 属于当前应用系统子域名
                    // 更新部署在此域名服务器上的应用系统授权
                    $ret = $this->updateLicenseToOneAppsys($client, $updateUri, $domain, $licenseContent);
                    if ($ret['errcode'] != 0) {
                        $errcode = 3001;
                        $faildomains[] = $domain;
                        $errmsg = $ret['errmsg'];
                    }
                }
            }
        }
        // 返回结果
        $ret = array('errcode'=>$errcode, 'errmsg'=>$errmsg);
        if (!empty($faildomains)) {
            $ret['data'] = array('faildomains'=>$faildomains);
        }
        return $ret;
    }

    /**
     * 更新部署在指定某个域名服务器上的应用系统授权信息
     *
     * @param $client 执行更新操作的API客户端对象
     * @param $updateUri 应用系统中执行域名更新服务的URI地址
     * @param $domain 指定某个域名服务器的域名
     * @param $licenseContent 用于更新的授权信息内容
     * @return 更新结果，数组对象，如：array("errcode"=>0,"errmsg"=>"")，返回的错误码定义：
     *         0    - 更新成功;
     *         3001 - 更新失败
     */
    public function updateLicenseToOneAppsys($client, $updateUri, $domain, $licenseContent)
    {
        if (strpos($domain, '*.') === false) { // 非通配域名，可以更新
            $url = 'http://'.$domain.$updateUri;
            $params = array('domains'=>'["'.$domain.'"]','license'=>$licenseContent,'action'=>'_saas_update_license');
            $ret = $client->invoke($url, $params);
            return $ret;
        } else { // 通配域名，不更新
            return array('errcode'=>0,'errmsg'=>'');
        }
    }

    /**
     * 动态创建Mysql数据库
     * @param $dbHost 数据库主机地址
     * @param $dbPort 数据库端口
     * @param $dbAdminUser 数据库管理权限用户（拥有创建数据库和创建用户权限）
     * @param $dbAdminPass 数据库管理权限用户密码
     * @param $dbName 要创建的数据库名称
     * @param $dbUser 要创建的数据库连接用户
     * @param $dbPass 要创建的数据库连接用户密码
     * @return 创建结果，数组对象，如：array("errcode"=>0,"errmsg"=>"")
     */
    public function createAppsysMysqlDB($dbHost, $dbPort, $dbAdminUser, $dbAdminPass, $dbName, $dbUser, $dbPass)
    {
        // 设置数据库连接配置
        $dbConfig = [
            'driver'    => 'mysql',
            'host'      => $dbHost,
            'port'      => $dbPort,
            'database'  => 'mysql',
            'username'  => $dbAdminUser,
            'password'  => $dbAdminPass,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
            'engine'    => null,
        ];
        try {
            // 建立数据库连接
            $factory = new ConnectionFactory(new Container());
            $conn = $factory->make($dbConfig);
            // 创建数据库
            $conn->statement('CREATE DATABASE IF NOT EXISTS '.$dbName.' DEFAULT CHARSET utf8 COLLATE utf8_general_ci;');
            // 创建用户
            $count = $conn->table('mysql.user')->where('User', $dbUser)->where('Host', '%')->count();
            if ($count > 0) { // 修改已有用户密码
                $conn->statement('SET PASSWORD FOR \''.$dbUser.'\'@\'%\' = PASSWORD(\''.$dbPass.'\');');
            } else { // 创建新用户
                $conn->statement('CREATE USER \''.$dbUser.'\'@\'%\' IDENTIFIED BY \''.$dbPass.'\';');
            }
            // 授权用户
            $conn->statement('GRANT ALL ON '.$dbName.'.* TO \''.$dbUser.'\'@\'%\';');
        } catch (\Exception $e) {
            Log::error('Auto create application database error: '.$e);
            return array('errcode'=>1001,'errmsg'=>$e->getMessage());
        } finally {
            if (!isset($conn)) {
                // 断开数据库连接
                $conn->disconnect();
            }
        }
        // 返回
        return array('errcode'=>0,'errmsg'=>'');
    }
    
    /**
     * 生成授权文件内容
     *
     * @param $user 授权客户信息
     * @param $appsys 授权应用系统信息
     * @param $domains 授权域名数组
     * @param $expireTime 授权过期时间，字符串，格式：Y-m-d H:i:s
     * @param $funcPackage 授权应用系统套餐号
     * @param $coreConfigInfo 应用系统核心配置信息，数组对象，定义：["db_host"=>"172.0.0.1","db_port"=>"3306",...]
     * @return 授权判断的PHP代码字符串
     */
    private function makeLicenseContent($user, $appsys, $domains, $expireTime, $funcPackage, $coreConfigInfo)
    {
        // 设置授权内容前缀
        $content = '?><?php ';
        // 生成SAAS环境变量，包含：AppID、AppSecret、应用系统标识、授权应用套餐号和应用系统配置信息
        $content .= sprintf('$%s = array(', VARNAME_SAAS_ENV);
        $content .= sprintf('"%s"=>"%s"', VARNAME_SAAS_APP_ID, $user->app_id);
        $content .= sprintf(',"%s"=>"%s"', VARNAME_SAAS_APP_SECRET, $user->app_secret);
        $content .= sprintf(',"%s"=>"%s"', VARNAME_APPSYS_ID, $appsys->shortname);
        $content .= sprintf(',"%s"=>"%s"', VARNAME_APPSYS_PACKAGE, $funcPackage);
        if (!empty($coreConfigInfo)) {
            foreach ($coreConfigInfo as $key=>$value) {
                $content .= sprintf(',"%s"=>"%s"', $key, $value);
            }
        }
        $content .= ');';
        // 生成判断是否为更新授权文件操作代码，如果是更新授权文件操作，那么不进行授权判断、不加载核心代码
        $content .= '$_fanwe_saas_auth_action = array_key_exists("action", $_REQUEST) ? trim($_REQUEST["action"]) : "";';
        $content .= 'if ($_fanwe_saas_auth_action != "_saas_update_license") {';
        // 生成域名判断代码、有效期判断代码和应用系统套餐号赋值代码
        $expireUnixTime = empty($expireTime) ? 0 : strtotime($expireTime);
        if (empty($expireUnixTime)) {
            $expireUnixTime = 0;
        }
        $content .= $this->makeLicenseAuthCode($domains, $expireUnixTime);
        // 生成应用系统核心代码
        if (!empty($appsys->core_code)) {
            $content .= str_replace("<?php", "", $appsys->core_code);
        }
        // 生成判断是否为更新授权文件操作代码的结束符
        $content .= '}';
        // 设置授权内容后缀
        $content .= ' ?>';
        /*
        // 去除代码中的换行符
        $content = str_replace(array("\r\n", "\r", "\n"), "", $content);
        */
        // 方维代码加密
        $tempLicenseFile = tempnam('.', 'fwl'); //tempnam(sys_get_temp_dir(), 'fwl');
        file_put_contents($tempLicenseFile, $content);
        $fanweManage = new \FanweManage;
        $content = $fanweManage->encrypt(basename($tempLicenseFile));
        unlink($tempLicenseFile);
        // 返回
        return $content;
    }
    
    /**
     * 生成授权判断的PHP代码
     *
     * @param $domains 授权域名数组
     * @param $expireTime 授权过期时间（UNIX时间戳）
     * @return 授权判断的PHP代码字符串
     */
    private function makeLicenseAuthCode(array $domains, $expireTime) 
    {
        // 设置过期时间变量和授权域名数组变量
        $code = '$_fanwe_saas_auth_expire = '.$expireTime.';$_fanwe_saas_auth_domains = array(';
        $first = true;
        foreach ($domains as $domain) {
            if (!$first) $code .= ',';
            $code .= '"'.$domain.'"';
            $first = false;
        }
        $code .= ');';
        // 添加授权判断代码
        $code .= LICENSE_AUTH_CODE;
        // 返回
        return $code;
    }
    
    /**
     * 保存授权信息到数据库中
     * @param $userId 授权客户ID
     * @param $appsysId 授权应用系统ID
     * @param $domains 授权域名数组
     * @param $expireTime 授权过期时间，字符串，格式：Y-m-d H:i:s
     * @param $funcPackage 授权应用系统套餐号
     * @param $coreConfigInfo 应用系统核心配置信息，数组对象，定义：["db_host"=>"172.0.0.1","db_port"=>"3306",...]
     * @param $licenseContent 用于更新的授权信息内容
     * @param $deployInSaas 授权系统是否部署在SAAS平台（是否自动创建核心配置）
     * @param $replaceIfExists 当指定用户已授权了指定应用系统时，是否覆盖替换，默认否
     * @return 保存结果，数组对象，如：array("errcode"=>0,"errmsg"=>"","data"=>array("faildomains"=>[]))
     */
    private function saveLicenseToDB($userId, $appsysId, $domains, $expireTime, $funcPackage, $coreConfigInfo, $licenseContent, $deployInSaas = false, $replaceIfExists = false)
    {
        // 获取已存在的授权信息，如果不存在，那么构建新的
        $systime = time();
        $license = AppsysLicense::where('user_id', $userId)->where('appsys_id', $appsysId)->where('deploy_in_saas', $deployInSaas)->first();
        if (empty($license)) { // 不存在，构建新的
            $license = new AppsysLicense();
        } else if (!$replaceIfExists) { // 已存在，且不覆盖，那么报错
            return array('errcode'=>2005,'errmsg'=>'用户已经授权了该应用系统！');
        }
        // 判断域名是否已被授权，且不跟当前的授权信息关联，如果存在已被授权的域名，那么报错
        $licenseDomains = AppsysLicenseDomain::whereIn('domain', $domains);
        if (!empty($license->id)) {
            $licenseDomains->where('appsys_license_id', '<>', $license->id);
        }
        if ($licenseDomains->count() > 0) {
            $data = array();
            $data['faildomains'] = array();
            $records = $licenseDomains->get();
            foreach ($records as $record) {
                $data['faildomains'][] = $record->domain;
            }
            return array('errcode'=>2003,'errmsg'=>'域名已经被授权给其他用户或应用系统！','data'=>$data);
        }
        // 开启数据库事务进行数据更新操作
        DB::beginTransaction();
        try {
            // 删除当前授权信息关联的旧的domain信息
            if (!empty($license->id)) {
                $license->domains()->forceDelete();
            }
            // 保存授权信息
            $license->user_id = $userId;
            $license->appsys_id = $appsysId;
            $license->appsys_func_package = $funcPackage;
            $license->appsys_core_config = empty($coreConfigInfo) ? '' : json_encode($coreConfigInfo);
            $license->expire_time = $expireTime;
            $license->license_info = $licenseContent;
            $license->deploy_in_saas = $deployInSaas;
            $license->disabled = false;
            $license->save();
            // 保存授权域名信息
            if (!empty($domains)) {
                foreach ($domains as $domain) {
                    $licenseDomain = new AppsysLicenseDomain();
                    $licenseDomain->domain = $domain;
                    $licenseDomain->appsys_license_id = $license->id;
                    $license->domains()->save($licenseDomain);
                }
            }
            // 当生成授权的应用产品有配置微信模版时，更新微信账号表中当前用户的“是否已同步微信模板”字段值为“否”
            $templateCount = AppsysWeixinTemplate::where('product_id', $appsysId)->count();
            if (!empty($templateCount) && $templateCount > 0) {
                WeixinAccount::where('user_id', $userId)->update(array('syn_template' => 0));
            }
            // 提交事务
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack(); // 回滚事务
            return array('errcode'=>1001,'errmsg'=>$e->getMessage());
        }
        // 返回结果
        $data = array('licenseid'=>$license->id);
        return array('errcode'=>0,'errmsg'=>'','data'=>$data);
    }

    /**
     * 根据域名到“应用系统授权域名信息表”中获取域名关联配置信息，以便获取此域名关联的授权配置信息。查找数据规则如下：
     * 1) 直接查找域名字段（domain）等于域名值（如：u1.o2o.fanwe.com）的记录，若查到则返回，否则继续；
     * 2) 查找第一级通配子域名记录（即：domain="*.o2o.fanwe.com"），若查到则返回，否则继续；
     * 3) 查找第二级通配子域名记录（即：domain="*.fanwe.com"），若查到则返回，否则继续；
     * 4) 查找第三级、第四级、...，直到找到记录或没有下一级为止。
     *
     * @param $domain 域名值
     * @return 获取到的域名关联配置信息。
     */
    private function getLicenseDomainInfo($domain)
    {
        // 直接查找
        $licenseDomains = AppsysLicenseDomain::where('domain', $domain)->first();
        if (!empty($licenseDomains)) { // 找到记录，则返回
            return $licenseDomains;
        }
        // 子域名通配查找
        do {
            // 获取子域名值
            $dotpos = strpos($domain, '.');
            if ($dotpos === false) {
                break;
            }
            $domain = trim(substr($domain, $dotpos+1));
            if ($domain == '') {
                break;
            }
            // 根据通配子域名查找
            $licenseDomains = AppsysLicenseDomain::where('domain', '*.'.$domain)->first();
        } while(empty($licenseDomains));
        // 返回结果
        return $licenseDomains;
    }
    
    /**
     * 判断字符串是否以指定子字符串结束
     *
     * @param $str 要判断的字符串
     * @param $substr 判断结束的子字符串
     * @return 是否以指定子字符串结束
     */
    private function strEndWidth($str, $substr)
    {
        return ($pos = strripos($str, $substr)) !== false && $pos == strlen($str) - strlen($substr);
    }

}
