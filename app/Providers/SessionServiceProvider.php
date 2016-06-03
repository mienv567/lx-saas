<?php

namespace App\Providers;

use Session;
use Memcached;
use Illuminate\Cache\MemcachedStore;
use Illuminate\Cache\Repository;
use Illuminate\Session\CacheBasedSessionHandler;
use Illuminate\Session\SessionServiceProvider as ServiceProvider;

class SessionServiceProvider extends ServiceProvider {
    public function boot() {
        Session::extend('ocs', function($app) {
        	
            $minutes = $app['config']['session.lifetime'];
            
            //memcached实例
            $config = $app['config']['ocs']['stores']['ocs_session'];
            $memcached = new Memcached;
            //关闭压缩功能
            $memcached->setOption(Memcached::OPT_COMPRESSION, false);
            
            //使用binary二进制协议
            $memcached->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
            
            foreach ($config['servers'] as $server) {
            	$memcached->addServer(
            			$server['host'], $server['port']
            	);
            }
            $memcached->setSaslAuthData($config['username'], $config['password']);
            
            //创建 MemcachedStore 对象
            $store = new MemcachedStore($memcached);
            
            $repository = new Repository($store);

            //end
            
            return new CacheBasedSessionHandler($repository, $minutes);
        });
    }
}
