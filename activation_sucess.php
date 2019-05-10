<?php
if (session_status()==1) {
    session_start(); 
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracker -- Test</title>
<link href="css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="css/mobile/layout.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<?php
include("header.php");
include("utility.php");
?>
<body>
	<h1>Money Finance Tracker -- Test</h1>
	<p>You have sucessfully activated your account.  Please <a href="login.html">login</a></p>
</body>
</html>
