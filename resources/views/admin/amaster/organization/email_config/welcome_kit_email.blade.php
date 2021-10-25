<!DOCTYPE html>
<html>
<head>
	<title>Welcome Kit Email</title>
</head>
<body>
      <h4>Welcome To 9Gem.net</h4>
      <p>Your Security Pin {{$info['security_pin']}} . Don't Share pin with anyone.</p>
      <p>Department: {{$info['department']}}</p>
      <p>Role Name : {{$info['role']}}</p>
      <p>Login : 9gem.net/{{$info['department']}}</p>
      <h4>Thanks</h4>
</body>
</html>
