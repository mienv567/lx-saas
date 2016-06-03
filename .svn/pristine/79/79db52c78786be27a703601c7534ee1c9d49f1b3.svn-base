<?php

namespace App\Providers;

use Cache;
use Memcached;
use Illuminate\Cache\CacheServiceProvider as ServiceProvider;
use Illuminate\Cache\MemcachedStore;
use Illuminate\Cache\Repository;

class CacheServiceProvider extends ServiceProvider {
    public function boot() {
        Cache::extend('ocs', function($app) {
            $config = $app['config']['ocs']['stores']['ocs_cache'];
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
            $store = new MemcachedStore($memcached, $app['config']['cache']['prefix']);

            $repository = new Repository($store);
            if ($app->bound('Illuminate\Contracts\Events\Dispatcher')) {
                $repository->setEventDispatcher(
                    $app['Illuminate\Contracts\Events\Dispatcher']
                );
            }
            return $repository;
        });
    }
}
