<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * 用户注册
     */
    public function create(){
        return view('users.create');
    }

    /** 
     * 用户展示页面
    */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * 注册 表单验证
     */
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        //注册成功提示
        session()->flash('success', '欢迎，牛气哄哄的Laravel');
        return redirect()->route('users.show', [$user]);
    }
}
