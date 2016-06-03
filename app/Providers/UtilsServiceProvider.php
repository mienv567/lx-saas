<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UtilsServiceProvider extends ServiceProvider
{
    
    public function register()
    {
        $this->app->singleton('UtilsService', function () {
            return new \App\Services\CommonUtils();
        });
    }
    
}

?>