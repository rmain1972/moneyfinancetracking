<?php
if (session_status()==1) {
    session_start(); 
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracker -- Reconcile Page</title>
<link href="css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="css/mobile/layout.css" rel="stylesheet" type="text/css">
</head>

<?php
include("noheader_secure.php");    
?>
<body onload="loadtrans(<?php echo $default_account; ?>)">
<script src="js/reconcile.js"></script>
<form name="account_form">
<input name="selected_account" type="hidden" value="<?php echo $default_account; ?>">
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
	<div class="solid_box">
        <div id="accounts">
	       <p id="account-1" class="account_item <?php if ($default_account==1) { echo "selected"; } ?>" onclick="loadtrans(1)">Main Account</p>
            <p id="account-2" class="account_item <?php if ($default_account==1) { echo "selected"; } ?>" onclick="loadtrans(2)">2nd Account</p>
        </div>
        <div>
            <hr>
            <form id="reconcile_form" name="reconcile_form" action="process_reconcile_form.php" method="post">
            <input name="selected_account" type="hidden" value="<?php echo $default_account; ?>">
            <p>Statement Begin Date:</p>
            <p><input id="statement_begin_date" type="date"></p>
            <p>Begining Balance:</p>
            <p><input name="beginning_balance" type="number" step="0.01"></p>
            <p>Ending Balance:</p>
            <p><input name="ending_balance" type="number" step="0.01"></p>
            <p>Debits:</p>
            <p id="debit_subtotal">&nbsp;</p>
            <input class="hide" name="debits" type="number" value="0.00" step="0.00">
            <p>Credits:</p>
            <p id="credit_subtotal">&nbsp;</p>
            <input class="hide" name="credits" type="number" value="0.00" step="0.00">
            <p>Computed Balance:</p>
            <p id="computed_subtotal">&nbsp;</p>
            <input id="json_data" name="json_reconcile_data" type="hidden" value="">
            </form>
        </div>
	</div>
    <!---------- Transactions Here ---------------------------------->
	<div id="transactions" class="overflow">
            Something Here
	</div>
<!------------------------ Row 3 ------------------------------------>
	<div>
        &nbsp;
	</div>
	<div class="main_button_grid solid_box">
	<p class="buttom_item" onclick="add_transaction()">Add Transaction</p>
    <p class="buttom_item" onclick="delete_account_data()">Delete Account Data</p>
    <p class="buttom_item" onclick="reset_reconcile()">Reset</p>
    <p class="buttom_item"><a href="accounts_setup.php">Add Account</a></p>
    <p class="buttom_item" onclick="do_reconcile()">Finish Reconcile</p>
    <p class="buttom_item"><a href="logout.php">Logout</a></p>
	</div>
</div>
</body>
</html>
