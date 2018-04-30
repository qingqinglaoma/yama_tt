<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Model\VerifyUser;
use App\Model\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
//use App\Mail\AccountVerifyMail;
//use Mail;
use App\Events\AccountAdded;
use Event;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

	$verifyUser = VerifyUser::create([
            'user_id' => $user->id,
           'token' => str_random(40),
        ]);

	$address = '';
        $city = '';
	$state = '';
        if(isset($data['address']))
        {
	     $address = $data['address'];
	}
	if(isset($data['city']))
        {
             $city = $data['city'];
        }
	if(isset($data['state']))
        {
             $state = $data['state'];
        }

	$profile = Profile::create([
            'user_id' => $user->id,
            'address' => $address,
	    'city'=> $city,
	    'state'=> $state,
	    'about'=>'',
            'picture'=>'images/default.jpeg',
        ]);


        //Mail::to($user->email)->send(new AccountVerifyMail($user));
        //Firing an event
        Event::fire(new AccountAdded($user));

        return $user;
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        return redirect('/login')->with('status', 'Account verification letter has been sent to your email. Please check your email to verify your account.');
    }

    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if(isset($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $status = "Congratulations! Your account is successfully verified. You can login now.";
            }else{
                $status = "Your account is already verified. You can login now.";
            }
        }else{
            return redirect('/login')->with('warning', "Sorry your account cannot be verified. please check your if email is valid or contact us for further support!");
        }

        return redirect('/login')->with('status', $status);
    }

}
