<?php
if (session_status()==1) {
    session_start(); 
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracker -- Edit Transaction Page</title>
<link href="./css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="./css/mobile/layout.css" rel="stylesheet" type="text/css">
</head>

<?php
    include("noheader_secure.php");
    include('mysqlnfo.php');
    include("utility.php");
    
    $transid = $_GET["transid"];
    $account = $_GET['account'];
    $return = $_GET['return'];
    $usertable = getusertable($_GET['account']);

    if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    // Select database
    if (mysqli_select_db($dbc, $userdb)) {
        $query = "SELECT * FROM $usertable WHERE transaction_id=$transid;";
        
        $result = mysqli_query($dbc, $query);
        
        if ($result) {
            $row=mysqli_fetch_array($result);
            
            if ($row) {
                $date1 = $row[1];
                $payee = $row[2];
                $credit = $row[5];
                $debit = $row[4];
                $category = $row[3];
                $memo = $row[7];
                $continue=1;
            } else {
                print '<p style="color: red;">Could get row on query due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>";
                $continue=0;
            }      
        } else {
            print '<p style="color: red;">Could execute query due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>";
        }
        
        $catinfo = new CategoryData($category);    
    } else {
        print "<p>Could not select database due to MYSQL ERROR: " . mysqli_error($dbc) . "</p>";
    }
    mysqli_close($dbc);
} else {
    print '<p style="color: red;">Could not connect to database server.</p>';
}

if (!$continue) {
    die("Unable to read database row ... edit_transaction.php");
} 
?>
<body onLoad="getcategories(<?php echo $category ?>)">
    <script src="js/debug.js"></script>
    <script src="js/edit_transaction.js"></script>
	<h1>Money Finance Tracker -- Add Transaction Page</h1>
    <form name="edit_transaction_form" method="post" action="process_edit_transaction.php">
    <input name="return" value="<?php echo $return; ?>" type="hidden">
    <input name="account" value="<?php echo $account; ?>" type="hidden">
    <input name="transid" value="<?php echo $transid; ?>">
    <input name="startingDate" value="2018-01-01" type="hidden">
    <div class="add_transaction_grid solid_box">
    <p id="trans_date_label">Date</p>
    <div id="trans_date_field">
        <input id="trans_date_field_input" style="width: 100%; height: 100%;" name="trans_date_field" type="date" value="<?php echo $date1; ?>">
        <p id="trans_date_error" class="error">Enter a valid date.  Date must be from the starting balance or beyond.</p>
    </div>
    <p id="payee_label">Pay To</p>
    <div id="payee_field">
        <input id="payee_field_input" style="width: 100%; height: 100%;" name="payee_field" type="text" value="<?php echo $payee; ?>">
        <p id="payee_field_error" class="error">Payee field cannot be blank!</p>
    </div>
    <p id="amount_label" class="align_right">Amount&nbsp;</p>
    <input id="amount_field" name="amount" type="number" step="0.01" value="<?php if ($credit==0) { echo $debit; } else { echo $credit; } ?>">
    <p id="category_label">Category</p>
    <select id="category_field" name="category">
        <option class="income_category_item" value="1">Category 1</option>
        <option class="expense_category_item" value="2">Category 2</option>
        <option class="expense_category_item" value="3">Category 3</option>
    </select>
    <p id="memo_label">Memo</p>
    <textarea id="memo_field" name="memo">
    <?php echo $memo; ?>
    </textarea>
    <input id="trans_submit_field" type="submit" onclick="return validate();" value="Update Transaction">
    </div>
    </form>
    <button onclick="delete_transaction(<?php echo $account . ',' . $transid . ", '$return'" ?>)">Delete</button>
</body>
</html>