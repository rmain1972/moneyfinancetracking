<?php
$username = $_GET["username"];
$activate = $_GET["code"];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracker -- Change Password</title>
<link href="./css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="./css/mobile/layout.css" rel="stylesheet" type="text/css">
</head>

<body>
    <script src="js/change_password.js"></script>
	<script src="js/debug.js"></script>
	<h1>Money Finance Tracker -- Change Password</h1>
    <form name="password_form" method="post" action="process_changepassword_activation_form.php">
    <input name="username" value="<?php echo $username; ?>" type="hidden">
	<div class="register_form_grid">
       
       <div>
            <p>Old Password</p>
        </div>
        <div>
            <input class="inputform" name="oldpassword" type="hidden" value="<?php echo $activate ?>">
            <p>&nbsp;</p>
        </div>
        <div>
        &nbsp;
        </div>
        <div>
            <p>New Password</p>
        </div>
        <div>
            <input class="inputform" name="newpassword" type="password">
            <p id="password_error" class="error">You must enter a password!</p>
        </div>
        <div>
        &nbsp;
        </div>
        <div>
            <p>Confirm Password:</p>
        </div>
        
        <div>
            <input class="inputform" name="userpass2" type="password">
            <p id="pass2_error" class="error">Paasswords must match!</p>
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
