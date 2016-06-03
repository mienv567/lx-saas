<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsysSaleItem extends Model
{
    use SoftDeletes;
    
    protected $table = 'saas_appsys_sale_item';

}
