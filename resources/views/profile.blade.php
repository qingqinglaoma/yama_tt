@extends('layouts.app')

@section('content')
<div class="container">
                <h1>Hello</h1>
		<h3>{{Auth::user()->name}}</h3><br>
		<img src="{{Auth::user()->getProfile->picture}}">
		<br>
		<a href="/uploadpicture">Upload Profile Picture</a>
                <br>
		<br>	
		<p>Addr:   {{Auth::user()->getProfile->address}}</p>
		<p>City:   {{Auth::user()->getProfile->city}}</p>
		<p>State:  {{Auth::user()->getProfile->state}}</p>
		<p>About:</p>
		<textarea readonly maxlength='250' rows="4" cols="50" name='about' id="about">"{{Auth::user()->getProfile->about}}"</textarea>
                <br>
		<a href="/editprofile">Edit Profile</a>	
		
</div>
@endsection
