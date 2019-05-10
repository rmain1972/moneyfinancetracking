<?php
if (session_status()==1) {
    session_start(); 
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracker -- Duplicate Email Error!</title>
<link href="css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="css/mobile/layout.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<?php
include("header.php");
?>
<body>
	<h1>Money Finance Tracker -- Duplicate Email Error!</h1>
	<p>Your email (<?php echo $_GET["email"]; ?>) is already in the database.  Please <a href="register.html">register</a> again with another email, or <a href="recover_account.html">recover account.</a></p>
</body>
</html>
