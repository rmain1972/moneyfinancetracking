<?php
if (session_status()==1) {
    session_start(); 
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracker -- Activate Account</title>
<link href="css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="css/mobile/layout.css" rel="stylesheet" type="text/css">
<script src="js/activate.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<?php
include("header.php");
include("utility.php");
    
$username = $_GET["username"];
?>
<body>
	<h1>Money Finance Tracker -- Enter Activation Code</h1>
	<form name="activate_form" method="POST" action="process_activate_account.php">
	<div class="register_form_grid">
        <div>
            <p>Activation Code:</p>
        </div>
        <div>
            <input class="inputform" name="activatecode" type="text" value="">
            <p id="code_error" class="error">You must enter a activation code!</p>
            <input name="username" type="hidden" value="<?php echo $username; ?>">
        </div>
        <div>
        &nbsp;
        </div>
        <p>&nbsp;</p>
        <input type="submit" onclick="return validate();">
        <div>
        &nbsp;
        </div>
	</div>
    </form>
	<img class="main-image" src="images/calculator.jpg" alt="Money Finance Tracker - Register Page image of a calculator">
</body>
</html>