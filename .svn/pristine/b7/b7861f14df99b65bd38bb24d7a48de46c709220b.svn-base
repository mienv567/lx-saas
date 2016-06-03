<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Response, Storage;
use Redirect;
use Auth;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Mail;
use SmsManager as SM;

class EmailVerifyController extends Controller
{
    
    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function send_code(Request $request)
    {
        $validator = Validator::make($request->only(['email']), [
            'email' => 'required|email|unique:saas_user',
        ], [
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式错误',
        ]);
        if ($validator->fails()) {
            return response()->json(
                array(
                    'success'=>false,
                    'type' => 'email_required',
                    'message' => $validator->getMessageBag()->first(),
                )
            );
        }

        if(session('laravel_email_info')){
            $se = session('laravel_email_info');
            $now = time();
            $again = $se['start_time'] + 60;
            if($again > $now){
                return response()->json(
                    array(
                        'success'=>false,
                        'type' => 'request_invalid',
                        'message' => '请求无效，请在60秒后重试',
                    )
                );
            }
        }
        $input = $request->all();
        $data['code'] = SM::generateCode();

        $flag = Mail::raw('你的邮箱验证码是'.$data['code'].'', function ($message)use($input) {
            $to = $input['email'];
            $message ->to($to)->subject('牛互动邮箱验证');
        });
        $data['deadline_time'] = time() + (15 * 60);
        $data['sent'] = true;
        $data['email'] =$input['email'];
        $data['start_time'] = time();
        session(['laravel_email_info' => $data]);

        if($flag){
            return response()->json(
                array(
                    'success'=>true,
                    'type' => 'email_send_success',
                    'message' => '邮件发送成功，请查收',
                )
            );
        }

    }




}
