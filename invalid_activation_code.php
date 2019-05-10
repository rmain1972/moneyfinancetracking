<?php
if (session_status()==1) {
    session_start(); 
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracker -- Invalid Activation Code Error!</title>
<link href="css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="css/mobile/layout.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<?php
include("header.php");
?>
<body>
	<h1>Money Finance Tracker -- Invalid Activation Code Error!</h1>
	<p>Please verify your email and activation code because we could not confirm your information.</p>
</body>
</html>
