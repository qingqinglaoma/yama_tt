<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Profile;

class ProfileController extends Controller
{
    //
	public function __construct()
    	{
       	 	$this->middleware('auth');
    	}

	public function index()
        {
                return view('profile');
        }

	public function getProfile()
	{
		return view('profile');
	}

	public function editProfile()
        {
		return view('editprofile');
	}

	public function editProfilePost(Request $request, $user_id)
        {
		$profile = Profile::where('user_id', $user_id)->first();
                if($request->has('about'))
		{
                	$profile->about = $request->input('about');
		}		
		if($request->has('address'))
                {       
                        $profile->address = $request->input('address');
                }   
		if($request->has('city'))
                {
                        $profile->city = $request->input('city');
                }  
		if($request->has('state'))
                {
                        $profile->state = $request->input('state');
                }  
		$profile->save();
                
                $msg = "Profile is Updated Succesfully";
                return response()->json(array('msg' => $msg),200);
        }

	public function uploadPicture()
        {
                return view('uploadpicture');
        }

	public function uploadPicturePost(Request $request, $user_id)
        {
		if( $request->hasFile('picture'))
		{
			$file = $request->file('picture');
                	$fileName = str_random(8).$file->getClientOriginalName();;
			//$extension = $file->getClientOriginalExtension();
       		        $name = $fileName;
			$file->move('images/',$name);	
			$profile = Profile::where('user_id', $user_id)->first();
			$profile->picture = 'images/'.$name;
			$profile->save();
			$msg = "New Profile Picture is Successfully uploaded!";
		}
		else
		{
			$msg = "No Valid Picture! Please try again";
		}

                return response()->json(array('msg' => $msg),200);
        }
           
}
