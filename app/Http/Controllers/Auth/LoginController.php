<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\User;
use App\Model\Profile;
use Socialite;

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

    public function authenticated(Request $request, $user)
    {
        if (!$user->verified) {
            auth()->logout();
            return back()->with('warning', 'Sorry, Your account is not verified yet, please check your email and click link to verify your account.');
        }
        return redirect()->intended($this->redirectPath());
    }

    //
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    { 
        return Socialite::driver($provider)->redirect();
    }

    /** 
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
	$authUser = $this->findOrCreateUser($user, $provider);
	Auth::login ($authUser, true);
        //dd($user);
    
        //$token = $user->token; 
	return redirect($this->redirectTo);
    }

    public function findOrCreateUser($user, $provider)
    {
	$authUser = User::where('provider_id',$user->id)->first();

	if($authUser)
	{
	    return $authUser;
	}

	$newUser = User::create([
		'name'		=> $user->name,
		'email'		=> $user->email,
		'provider'	=> strtoupper($provider),
		'provider_id'	=> $user->id
	]);

	$profile = Profile::create([
            'user_id' => $newUser->id,
            'address' => '',
            'city'=> '',
            'state'=> '',
            'about'=>'',
            'picture'=>'images/default.jpeg',
        ]);


	return $newUser;
    }
}
