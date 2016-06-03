<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class DBLog extends Facade
{
    
    protected static function getFacadeAccessor() 
    {
        return 'DBLogService';
    }
    
}

?>