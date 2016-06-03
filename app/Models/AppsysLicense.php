<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppsysLicense extends Model
{
    
    protected $table = 'saas_appsys_license';
    
    public function domains()
    {
        return $this->hasMany('App\Models\AppsysLicenseDomain', 'appsys_license_id', 'id');
    }
    
}
