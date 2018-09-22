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
}
