<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 返回json格式的应答结果
     * @param $errcode 错误码
     * @param $errmsg 错误信息
     * @param $data 包含的数据
     * @return $data
     */
    public function responseJson($errcode, $errmsg, $data = NULL)
    {
        return response()->json(['errcode' => $errcode, 'errmsg' => $errmsg, 'data' => $data]);
    }
    
}
