<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $users = User::select('name')->where('state','=','Activo')->orderBy('name','asc')->get();
        return view('auth.login', ['users'=>$users]);
    }


    public function login(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'password' => 'required|string'
        ]);

        if(Auth::attempt(['name' => $request->name, 'password' => $request->password, 'state' => 'Activo'])){
            return redirect()->route('main'); 
        }
        return back()
        ->withErrors(['name'=>trans('auth.failed')])
        ->withInput(request(['name']));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');

    }
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /*use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
   /* public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }*/
}
