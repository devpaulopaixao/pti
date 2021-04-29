<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
//use App\Http\Requests;

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
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){

        $user = \App\User::where('email', $request->email)->first();

        if(isset($user) && auth()->guard('web')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){

            if (auth()->user()->isLogged()) {

                $this->logoutOtherDevices();
            }

            $gps = geoip()->getLocation($request->ip());

            $user->access_logs()->create([
                "ip" => $gps->ip,
                "iso_code" => $gps->iso_code,
                "country" => $gps->country,
                "city" => $gps->city,
                "state" => $gps->state,
                "state_name" => $gps->state_name,
                "postal_code" => $gps->postal_code,
                "lat" => $gps->lat,
                "lon" => $gps->lon,
                "timezone" => $gps->timezone,
                "currency" => $gps->currency
            ]);

            $this->updateSessionId(\Session::getId());

            return redirect('/home');

        }else{
            return back();
        }

    }

    private function updateSessionId(string $id = null)
    {
        auth()->user()->session_id = $id;
        auth()->user()->save();
    }

    private function logoutOtherDevices()
    {
        session()->getHandler()->destroy(auth()->user()->session_id);
    }
}
