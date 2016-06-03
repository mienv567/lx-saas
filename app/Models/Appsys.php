<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appsys extends Model
{
    use SoftDeletes;
    
    protected $table = 'saas_appsys';
    
}
