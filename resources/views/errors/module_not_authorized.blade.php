<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Access Denied</title>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="icon" href="images/favicon.ico" type="image/x-icon" />

<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('public/adminty/assets/css/error.css') }}" /> 
</head>
<body>
<div id="container" class="container" style="padding-top: 5px; padding-bottom:5px; max-height:95%">
<ul id="scene" class="scene"> 
<li class="layer" data-depth="1.00"><img src="{{ asset('public/adminty/images/404/404-01.png') }}"></li>
<li class="layer" data-depth="0.60"><img src="{{ asset('public/adminty/images/404/shadows-01.png') }}"></li>
<li class="layer" data-depth="0.20"><img src="{{ asset('public/adminty/images/404/monster-01.png') }}"></li>
{{-- <li class="layer" data-depth="0.40"><img src="{{ asset('public/adminty/images/404/text-01.png') }}"></li> --}}
<li class="layer" data-depth="0.10"><img src="{{ asset('public/adminty/images/404/monster-eyes-01.png') }}"></li>
</ul>
<h1>You are not authorized to access this page</h1>
 
<a href="{{ route('warehouse.dashboard') }}" class="btn">Go back to dashboard</a>
</div>

<script src="{{ asset('public/adminty/assets/js/parallax.js') }}"></script>
<script>
	// Pretty simple huh?
	var scene = document.getElementById('scene');
	var parallax = new Parallax(scene);
	</script>
</body>
</html>
