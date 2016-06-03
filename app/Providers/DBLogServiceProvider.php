<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DBLogServiceProvider extends ServiceProvider
{
    
    public function register()
    {
        $this->app->singleton('DBLogService', function () {
            return new \App\Services\DBLog();
        });
    }
    
}

?>