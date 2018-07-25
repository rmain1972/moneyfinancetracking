<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracker -- Account Setup Page</title>
<link href="./css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="./css/mobile/layout.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="getMedia();">
    <script src="js/accountsetup.js"></script>
	<script src="js/debug.js"></script>
    
<?php
include("header_secure.php");  
?>

	<h1>Money Finance Tracker -- Account Setup Page</h1>
    <form name="accountsetup_form" method="post" action="process_accountsetup.php">
	<div class="accountsetup_form_grid">
        <div>
            <p>Account name:</p>
        </div>
        <div>
            <input class="inputform" name="accountname" type="text">
            <p id="name_error" class="error">You must enter an account name!</p>
        </div>
        <div>
        &nbsp;
        </div>
<!---------- Next Row ------------------------------------------------------------------->
        <div>
            <p>Starting Balance Date:</p>
        </div>
        <div>
            <input class="inputform" name="starting_balance_date" type="date">
            <p id="sbdate_error" class="error">You must enter a starting balance date!</p>
        </div>
        <div>
        &nbsp;
        </div>
<!---------- Next Row ------------------------------------------------------------------->
        <div>
            <p>Starting Balance:</p>
        </div>
        <div>
            <input class="inputform" name="starting_balance" type="number" step="0.01">
            <p id="sbdnum_error" class="error">You must enter a starting balance!</p>
        </div>
        <div>
        &nbsp;
        </div>
<!---------- Next Row ------------------------------------------------------------------->
        <p>&nbsp;</p>
        <input type="submit" onclick="return validate();">
        <div>
        &nbsp;
        </div>
	</div>
    </form>
	<img class="main-image" src="images/calculator.jpg" alt="Money Finance Tracker - Register Page image of a calculator">
	<p id="data">Data here</p>
</body>
</html>
