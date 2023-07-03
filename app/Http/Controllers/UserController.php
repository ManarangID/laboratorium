<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\UserLogin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }  
      
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $emailReq = request()->email;
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $email = User::where('email',  $emailReq)->pluck('name');
            event(new UserLogin($email));
            $strEmail = Str::replaceArray('?',$email,'Selamat Datang ?');
            return redirect()->intended('dashboard')->withSuccess($strEmail);
        }
  
        return redirect('login')->withError('Login details are not valid');
    }
}
