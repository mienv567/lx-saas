<?php
use App\Models\User;
\Validator::extend('flow_money', function ($attribute, $value, $parameters) {
    if(is_numeric($value)){
        if($value<=0){
            return false;
        }
        if($value % 100 == 0){
            return true;
        }
    }
    return false;
});

Validator::extend('password_geshi', function ($attribute, $value, $parameters) {
    $pattern = '/^(?=.*[0-9])(?=.*[a-zA-Z])/';
    if(preg_match($pattern,$value)){
            return true;

    }
    return false;
});


Validator::extend('password_r', function ($attribute, $value, $parameters) {
    $account = User::find(Auth::id());
    $au = Auth::attempt(['username' => $account->username, 'password' => $value]);
    if($au){
        return true;
    }else{
        return false;
    }
});

Validator::extend('sms_number', function ($attribute, $value, $parameters) {
    if(is_numeric($value)){
        if($value<=0){
            return false;
        }
        if($value % 5000 == 0){
            return true;
        }
    }
    return false;
});