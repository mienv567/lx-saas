<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Response, Storage;
use Redirect;
use Auth;
use Validator;
use App\Models\Message;
use Illuminate\Support\Facades\Session;
/**
 * 企业用户账号设置控制器类
 */
class MessageController extends Controller
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

    /**
     * 显示首页
     *
     * @return \Illuminate\Http\Response
     */
    public function message_list(Request $request)
    {
        $user = Auth::user();
        $search_title = $request->title;
        $messages = $user->messages()->where('msgtype',0)->orderBy('id','desc')->where(function ($query) use ($search_title){
            if($search_title){
                $query->where('title','like','%'.$search_title.'%');
            }
        })->paginate(10);
        return view('user.message_list', compact('messages','search_title'));
    }

    public function message_detail(Request $request){
        $user = Auth::user();
        $message = Message::find($request->id);
        if($user->id == $message->user_id){
            return view('user.message_detail', compact('message'));
        }else{
            echo "查无此页";
        }
    }



    public function bulletin_list(Request $request){
        $search_title = $request->title;
        $bulletins = Message::where('msgtype',1)->orderBy('id','desc')->where(function ($query) use ($search_title){
            if($search_title){
                $query->where('title','like','%'.$search_title.'%');
            }
        })->paginate(10);
        return view('user.bulletin_list', compact('bulletins','search_title'));
    }

    public function bulletin_detail(Request $request){

        $bulletin = Message::find($request->id);
        return view('user.bulletin_detail', compact('bulletin'));
    }

}
