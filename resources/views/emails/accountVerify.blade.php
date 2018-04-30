<!DOCTYPE html>
<html>
<head>
    <title>Account Verification</title>
</head>
<body>
      <div>
           <p>Please verify that you want to use this email as xxx website account. If it is not registered by you, please ignore this.</p>
      </div>
      <div>
           <a href="{{url('user/verify', $user->verifyUser->token)}}">Click To Verify</a>
      </div>
</body>
</html>

