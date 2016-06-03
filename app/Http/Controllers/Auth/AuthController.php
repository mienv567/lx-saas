<?php

namespace App\Http\Controllers\Auth;

use App\Models\Message;
use App\Models\User;
use App\Models\MessageTemplate;
use App\Saas\SAASUtil;
use Validator;
use Auth;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $username = 'mobile';

    protected $redirectAfterLogout = 'login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'mobile' => 'required|zh-mobile|confirm_mobile_not_change|unique:saas_user',
            'verifyCode' => 'required|verify_code|confirm_mobile_rule:mobile_required',
            'password' => 'required|min:6|password_geshi',
        ], [

            'mobile.required' => '手机号不能为空',
            'verifyCode.required' => '手机验证码不能为空',
            'password.required' => '密码不能为空',
            'password.password_geshi' => '必须是数字与字母的组合',
            'mobile.zh-mobile' => '手机格式有误',
        ]);
    }

    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {

            /*$this->throwValidationException(
                $request, $validator
            );*/

            //验证失败后建议清空存储的短信发送信息，防止用户重复试错
            //\SmsManager::forgetSentInfo();

            //返回错误
            return response()->json(
                array(
                    'err' => 1,
                    'msg' => $validator->getMessageBag(),
                )
            );

        }

        Auth::guard($this->getGuard())->login($this->create($request->all()));
        $mt_info = MessageTemplate::where('event','ACCOUNT_REGISTER_SUCC')->get();
        foreach($mt_info as $mt){
            $message = new Message();
            $message->title = $mt->title;
            $message->content = $mt->content;
            $message->user_id = Auth::id();
            $message->save();
        }
        return response()->json(
            array(
                'err' => 0,
                'redirect' => url('/')
            )
        );

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['mobile'],
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
            'app_id' => SAASUtil::makeAppId(),
            'app_secret' => SAASUtil::makeAppSecret(),
            'app_password' => SAASUtil::makeAppSecret(),
        ]);
    }


    public function postLogin(Request $request)
    {
        $input = $request->all();
        $logintype = $this->loginUsername();
        $validator = Validator::make($request->only(['captcha']), [
            'captcha' => 'required|captcha',
        ], [
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '验证码错误',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($request->only($logintype, 'remember'))
                ->withErrors([
                    $logintype => $validator->getMessageBag()->first(),
                ]);
        }
        if (Auth::attempt(['username' => $input['username'], 'password' => $input['password']]))
        {
            $logintype = 'username';
        }
        if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']]))
        {
            $logintype = 'email';
        }
        $this->validate($request, [
            $logintype => 'required', 'password' => 'required',
        ]);
        $throttles = $this->isUsingThrottlesLoginsTrait();
        $lockedOut =  app(RateLimiter::class)->tooManyAttempts(
            mb_strtolower($request->input($logintype)).'|'.$request->ip(),
            $this->maxLoginAttempts(), $this->lockoutTime() / 60
        );
        if ($throttles && $lockedOut) {
            $this->fireLockoutEvent($request);
            $seconds = $this->secondsRemainingOnLockout($request);
            $min = floor($seconds / 60);
            return redirect()->back()
                ->withInput($request->only($logintype, 'remember'))
                ->withErrors([
                    $logintype => $this->getLockoutErrorMessage($min),
                ]);
        }
        $credentials = $request->only($logintype, 'password');
        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {

            return $this->handleUserWasAuthenticated($request, $throttles);
        }
        if ($throttles && ! $lockedOut) {
            app(RateLimiter::class)->hit(
                mb_strtolower($request->input($logintype)).'|'.$request->ip()
            );
        }
        return redirect()->back()
            ->withInput($request->only($logintype, 'remember'))
            ->withErrors([
                $logintype => $this->getFailedLoginMessage(),
            ]);
    }

    public function getLogout()
    {
        Session::forget("lo_appkey");
        return $this->logout();
    }


}
