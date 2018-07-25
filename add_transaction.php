<?php
if (session_status()==1) {
    session_start(); 
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracker -- Register Page</title>
<link href="./css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="./css/mobile/layout.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="getcategories()">
<?php
include("header_secure.php");
$account=$_GET["account"];
$return=$_GET["return"];
?>
	<script src="js/debug.js"></script>
    <script src="js/add_transaction.js"></script>
	<h1>Money Finance Tracker -- Add Transaction Page</h1>
    <form name="addtransaction_form" method="post" action="process_newtransaction.php">
    <input name="return" value="<?php echo $return; ?>" type="hidden">
    <input name="account" value="<?php echo $account ?>" type="hidden">
    <input name="startingDate" value="2018-01-01" type="hidden">
    <div class="add_transaction_grid solid_box">
    <p id="trans_date_label">Date</p>
    <div id="trans_date_field">
        <input id="trans_date_field_input" style="width: 100%; height: 100%;" name="trans_date_field" type="date">
        <p id="trans_date_error" class="error">Enter a valid date.  Date must be from the starting balance or beyond.</p>
    </div>
    <p id="payee_label">Pay To</p>
    <div id="payee_field">
        <input id="payee_field_input" style="width: 100%; height: 100%;" name="payee_field" type="text">
        <p id="payee_field_error" class="error">Payee field cannot be blank!</p>
    </div>
    <p id="amount_label" class="align_right">Amount&nbsp;</p>
    <input id="amount_field" name="amount" type="number" step="0.01">
    <p id="category_label">Category</p>
    <select id="category_field" name="category">
        <option class="income_category_item" value="1">Category 1</option>
        <option class="expense_category_item" value="2">Category 2</option>
        <option class="expense_category_item" value="3">Category 3</option>
    </select>
    <p id="memo_label">Memo</p>
    <textarea id="memo_field" name="memo">
    </textarea>
    <input id="trans_submit_field" type="submit" onclick="return validate();" value="Enter Transaction">
    </div>
    </form>
</body>
</html>