<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Auth;

class LoginController extends Controller
{
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('adminLogout');
    }

    public function showAdminLoginForm()
    {
        return view('auth.login');
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        $remember = $request->has('remember') ? true : false; 

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $remember)) {

            //return redirect()->intended('/admin-panel');
            return redirect()->route('homeAdminPanel');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function adminLogout(){
        Auth::guard('admin')->logout();
        return redirect()->route('adminLoginForm');
    }

    public function userLogin(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
    
        ]);
    
        $remember = $request->has('remember') ? true : false;
    
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $remember))
        {
            return redirect()->intended('/');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function getUser(){
        return $request->user();
    }

    public function home() {
        return redirect('login');
    }

}