<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class SessionController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
    /**
     * 展示登录页面
     */
    public function create(){
        return view('session.create');
    }


    /**
     * 数据验证，及入库
     */
    public function store(Request $request){
        $credentials = $this->validate($request,[
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);

        if(Auth::attempt($credentials, $request->has('remember'))){
            //登录成功操作
            session()->flash('success', '欢迎回来');
            return redirect()->intended( route('users.show', [Auth::user()]));
        }else{
            //登录失败
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back();
        }
        return;
    }


    /**
     * 退出
     */
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
