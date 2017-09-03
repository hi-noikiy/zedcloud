<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginPost;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /**
     * Show login view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login() {
    	//return bcrypt('xiaohangjia321!');
    	
    	
    	
        return view('login');
    }

    /**
     * Login authorization
     *
     * @param LoginPost $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function check(LoginPost $request) {
        $username = $request->input('username');
        $password = $request->input('password');
        $remember = $request->input('remember', 0);

        if (Auth::attempt(['username' => $username, 'password' => $password], $remember)) {
            // Authentication passed...
            return redirect('index/list');
        } else {
            return back()->withInput(['username' => $username, 'remember' => $remember])->withErrors(['username' => trans('login.exists')]);
        }
    }
}
