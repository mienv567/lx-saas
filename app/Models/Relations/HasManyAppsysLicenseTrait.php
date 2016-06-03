<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/3
 * Time: 15:58
 */

namespace App\Models\Relations;

Trait HasManyAppsysLicenseTrait
{

    public function use_app_licenses()
    {

        return $this->hasMany('App\Models\AppsysLicense', 'user_id', 'id');
    }

}