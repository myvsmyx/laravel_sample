<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    
    /**
     * 用户注册
     */
    public function create(){
        return view('user.create');
    }
}
