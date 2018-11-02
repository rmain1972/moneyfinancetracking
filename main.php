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
<div class="transaction_grid">
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
	<div id="accounts" class="solid_box">
	<p class="button_item" id="account-1" class="account_item <?php if ($default_account==1) { echo "selected"; } ?>" onclick="loadtrans(1)">Main Account</p>
    <p class="button_itme" id="account-2" class="account_item <?php if ($default_account==1) { echo "selected"; } ?>" onclick="loadtrans(2)">2nd Account</p>
	</div>
    <!---------- Transactions Here ---------------------------------->
	<div id="transactions" class="overflow">
            <img class="img_center" src="images/pleasewait.gif">
	</div>
<!------------------------ Row 3 ------------------------------------>
	<div> 
        <select id="date_controls" onchange='FilterTransactions()'>
            <option value="1">All Dates</option>
            <option value="2">Last 30 Days</option>
            <option value="3">Last 60 Days</option>
            <option value="4">Last 90 Days</option>
        </select>
        <br>
        <p2>Last Login: <?php echo $_SESSION["last_logon"]; ?></p2>
	</div>
	<div class="main_button_grid solid_box">
	<p class="buttom_item" onclick="add_transaction()">Add Transaction</p>
    <p class="buttom_item" onclick="delete_account_data()">Delete Account Data</p>
    <p class="buttom_item">Button 3</p>
    <p class="buttom_item"><a href="accounts_setup.php">Add Account</a></p>
    <p class="buttom_item"><a href="reconcile.php">Reconcile</a></p>
    <p class="buttom_item"><a href="logout.php">Logout</a></p>
	</div>
</div>
</body>
</html>
