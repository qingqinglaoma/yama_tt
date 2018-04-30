@extends('layouts.app')

@section('content')
<div class="container">
<html>
<head>
<title>Edit Profile</title>
<link rel="stylesheet" href="css/style.css" />
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed|Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
$(document).ready(function (e) {
$("#editprofile").on('submit',(function(e) {
e.preventDefault();
var user_id = $('input#user_id').val();
var address = $('input#address').val();
var city = $('input#city').val();
var state = $('input#state').val();
var about = $('textarea#about').val();
var _token= $('input#_token').val();
var formData = new FormData();
formData.append("_token", _token);
formData.append("address", address);
formData.append("city", city);
formData.append("state", state);
formData.append("about", about);


$.ajax({
url: '/editprofile/'+ user_id, // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: formData, // Data sent to server, a set of key/value pairs (i.e.form fields and values)
dataType: "json",
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
	alert(data.msg);
	window.location = '/profile';
}
});
}));

});
</script>
</head>
<body>
<div class='main'>
<h1>Edit Profile</h1><br/>
<hr>
<form id="editprofile" action="" method="post">
<div>
<label></label><br/>
<input type="hidden" id="_token" value="{{ csrf_token()}}" />
<input type="hidden" id="user_id" value="{{Auth::user()->id}}" />
<label>Addr:</label>
<input type="input" id="address" maxlength="50" value="{{Auth::user()->getProfile->address}}" /><br/>
<label>City:</label>
<input type="input" id="city" maxlength="20" value="{{Auth::user()->getProfile->city}}" /><br/>
<label>State:</label>
<input type="input" id="state" maxlength="20" value="{{Auth::user()->getProfile->state}}" /><br/>
<label>About:</label>
<textarea maxlength='250' rows="4" cols="50" name='about' id="about">"{{Auth::user()->getProfile->about}}"</textarea>

<input type="submit" value="Submit" class="submit" />
</div>
</form>
</div>
</body>
</html>
</div>
@endsection
