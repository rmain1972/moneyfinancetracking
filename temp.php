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
include("header_secure.php");
include("utility.php");
?>
<body>
	<h1>Money Finance Tracker -- Test</h1>
	<p><?php echo randCode(9); ?></p>
</body>
</html>
