<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function authorization(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
            
            if ($admin->role == User::ADMIN) {
                    // Session::put('userid', $admin);
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('admin.login')->with('fail','You are not authorize to access this page');
            }
        } else {
            $message = 'Your credentials are incorrect';
        }

        return redirect()->route('admin.login')->with('fail', $message);
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
