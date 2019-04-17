<?php
if (session_status()==1) {
    session_start(); 
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracker -- Main Ledger Page</title>
<link href="css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="css/mobile/layout.css" rel="stylesheet" type="text/css">
</head>

<?php
include("noheader_secure.php");
include("utility.php");
?>
<body onload="loadtrans(<?php echo $default_account . ', ' . $default_mode ?>)">
<script src="js/main.js"></script>
<form name="account_form">
<input name="selected_account" type="hidden" value="<?php echo $default_account; ?>">
<input name="selected_mode" type="hidden" value="<?php echo $default_mode; ?>">
</form>
<div class="print_grid">
<!------------------------ Row 1 ------------------------------------>
	<div>
	<p>Money Finance Tracking</p>
	</div>
	<div>
	<div class="transaction_item">
		<!-------------- Sub Row 1 ---------------------------------->
		<p class="tiday">Date</p>
		<p class="tipayee">Payee</p>
		<p class="ticredit">Credit</p>
		<p class="tidebit">Debit</p>
		<p class="tibalance">Balance</p>
		<p></p>
		<p class="timemo">Memo</p>
		<!-------------- Sub Row 2 ---------------------------------->
		<p>&nbsp;</p>
		<p class="ticat">Category</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
	</div>
	</div>
<!------------------------ Row 2 ------------------------------------>
    <!---------- Transactions Here ---------------------------------->
	<div id="transactions" class="overflow">
            <img class="img_center" src="images/pleasewait.gif">
	</div>
<!------------------------ Row 3 ------------------------------------>
</div>
</body>
</html>
