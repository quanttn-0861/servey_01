<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use Response;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        $data = $request->only([
            'email',
            'password',
        ]);

        $authenticated = Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
            'status' => config('users.status.active'),
        ]);

        if ($authenticated) {
            // if user is admin then redirect to Admin page
            if (Auth::user()->level == config('users.level.admin')) {
                // redirect to admin page
                // return redirect()->action('Admin\DashboardController@index');
            }
        }

        return response()->json($authenticated);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $locale = $request->session()->get('locale');
        $request->session()->flush();
        $request->session()->put('locale', $locale);
        $request->session()->regenerate();

        return redirect()->action('SurveyController@index');
    }
}
