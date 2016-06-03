<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/3
 * Time: 15:58
 */

namespace App\Models\Relations;

Trait HasManyMessagesTrait
{

    public function messages()
    {

        return $this->hasMany('App\Models\Message', 'user_id', 'id');
    }

}