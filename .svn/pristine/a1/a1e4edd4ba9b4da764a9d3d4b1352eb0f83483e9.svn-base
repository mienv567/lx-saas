<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Password;
use Validator;
use App\Models\User;
use Session;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    //use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 找回密码方式
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getForget()
    {
        return view('auth.passwords.forget');
    }

    public function postForget(Request $request)
    {
        $validator = Validator::make($request->only(['username', 'captcha']), [
            'username' => 'required',
            'captcha' => 'required|captcha',
        ], [
            'username.required' => '账号不能为空',
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '验证码错误',
        ]);

        if ($validator->fails()) {
            return response()->json(
                array(
                    'err' => 1,
                    'msg' => $validator->getMessageBag(),
                )
            );
        }
        $username = $request->input('username');
        $info = User::where('username', $username)->orwhere('mobile', $username)->orwhere('email', $username)->first();
        if(!$info['mobile']){
            return response()->json(
                array(
                    'err' => 1,
                    'msg' => array('username'=> '用户未绑定手机号，请与管理员联系'),
                )
            );
        }
        if($info){
            session(['findPass.id' => $info['id']]);
            session(['findPass.username' => $username]);
            session(['findPass.mobile' => $info['mobile']]);
            session(['findPass.email' => $info['email']]);

            return response()->json(
                array(
                    'err' => 0,
                    'msg' => session('findPass.mobile'),
                )
            );
        }else{
            return response()->json(
                array(
                    'err' => 1,
                    'msg' => array('username'=> '用户不存在'),
                )
            );
        }
    }

    /**
     * 验证手机
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postVerify(Request $request)
    {
        // 账号是通过手机注册，所以至少保证是有手机号码。暂时仅支持通过手机找回密码
        $validator = Validator::make($request->only(['verifyCode']), [
            'verifyCode' => 'required|verify_code',
        ], [
            'verifyCode.required' => '验证码不能为空',
            'verifyCode.verify_code' => '验证码错误',
        ]);

        if ($validator->fails()) {
            return response()->json(
                array(
                    'err' => 1,
                    'msg' => $validator->getMessageBag(),
                )
            );
        }
        return response()->json(
            array(
                'err' => 0,
                'redirect' => url('password/reset')
            )
        );
    }

    public function getSuccess()
    {
        return view('auth.passwords.success');
    }

    public function postReset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:6|password_geshi',
        ], [
            'password.password_geshi' => '必须是数字与字母的组合',
        ]);
        if ($validator->fails()) {
            return response()->json(
                array(
                    'err' => 1,
                    'msg' => $validator->getMessageBag(),
                )
            );
        }
        $user_id = (int)session('findPass.id');
        if($user_id==0){
            return response()->json(
                array(
                    'err' => -1,
                    'msg' => '用户不存在',
                )
            );
        }
        $user = User::find($user_id);
        if(empty($user)){
            return response()->json(
                array(
                    'err' => -1,
                    'msg' => '用户不存在',
                )
            );
        }
        $user->password = bcrypt($request->input('password'));
        $user->save();
        Session::forget('findPass');
        return response()->json(
            array(
                'err' => 0,
                'redirect' => url('password/success')
            )
        );
    }

    /**
     * 重置密码
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm()
    {
        return view('auth.passwords.reset');
    }


}
