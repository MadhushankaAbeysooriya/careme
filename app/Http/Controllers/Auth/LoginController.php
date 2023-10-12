<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\LoginDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    }


    function login(Request $request){        
        // Sanitize the input values here
        $email = filter_var($request->input('email'), FILTER_SANITIZE_EMAIL);
        $password = filter_var($request->input('password'), FILTER_SANITIZE_STRING);

        $request->validate([
            'email'=>'required|string|max:255',
            'password'=>'required|string|min:6|max:255',
        ]);        

        $user = User::where('email',$email)->first();

        //dd($user->name);

        if(!isset($user)) 
        {
            return redirect()->route('login')->with('error','Credentials not Available');            
        }else
        {
            if($user->status == 0)
            {
                return redirect()->route('login')->with('error','User de-Activated');
            }elseif($user->suspend == 1){
                return redirect()->route('login')->with('error','User Suspended');
            }

            $creds = $request->only('email','password');
            //dd($creds);
                if(Auth()->attempt($creds)){
                    //dd($request);                
                    User::find(auth()->user()->id)->update([
                        'last_login_ip'=> $request->ip(),
                        'attempts' => 0,                 
                    ]);
                    
                    LoginDetail::create([
                        'user_id'=>Auth::user()->id,
                        'login_ip'=> $request->ip(),
                    ]);
                    return redirect()->route('home');                
                }else{
                    if($user->attempts >= 3)
                    {
                        User::find($user->id)->update([                        
                            'suspend' => 1,                 
                        ]);

                        return redirect()->route('login')->with('error','User Suspended');
                    }
                    User::find($user->id)->update([                        
                        'attempts' => $user->attempts + 1,                 
                    ]);

                    return redirect()->route('login')->with('fail','Incorrect Credentials');
                }
        }
        
    }
}
