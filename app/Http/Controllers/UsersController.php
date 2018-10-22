<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;

class UsersController extends Controller
{

    public function __construct(){
        //验证是否登录
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index'],
        ]);

        $this->middleware('guest', [
            'only' => ['create']
        ]);
        
        
    }

    public function index(){
        // $users = User::all();
        $users = User::paginate(5);
        return view('users.index', compact('users'));
    }

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
        Auth::login($user);
        session()->flash('success', '欢迎，牛气哄哄的Laravel');
        return redirect()->route('users.show', [$user]);
    }

    /**
     *  用户编辑
     */
    public function edit(User $user){
        //授权策略，只能更改自己的数据
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    /**
     * 更新编辑
     */
    public function update(User $user, Request $request){
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        //授权策略，只能更改自己的数据
        $this->authorize('update', $user);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料编辑成功');

        return redirect()->route('users.show', $user->id);
    }

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }
}
