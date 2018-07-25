<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracking -- Add Transaction Process Page</title>
<link href="css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="css/mobile/layout.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    
<?php
include("header_secure.php");    
?>
    
<section id="Main-Page">
<div id="main-page-content">
	<div id="main-page-content_container">
		<div class="three_fourth">
<?php
	//$username = $_POST["username"];
	//User is logged in at this point
        
include('mysqlnfo.php');
include("utility.php");

    //
if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    // Select database
    if (mysqli_select_db($dbc, $userdb)) {
        print "<p>Database selected successfully.</p>";
        
        $return = $_POST["return"];
        $transid = $_POST["transid"];
        $usertable = getusertable($_POST['account']);
        $trans_date = $_POST['trans_date_field'];
        $payee_field = htmlentities($_POST['payee_field']);
        $payee_field = mysqli_real_escape_string($dbc, $payee_field);
        $amount = $_POST['amount'];
        $category = $_POST['category'];
        $memo = htmlentities($_POST['memo']);
        $memo = mysqli_real_escape_string($dbc, $memo);
        $catinfo = new CategoryData($category);
        echo "<p>$catinfo->CategoryType</p>";
        if ($catinfo->CategoryType == "Expense") {
            $query = "UPDATE $usertable SET transdate = '$trans_date', payee = '$payee_field', category_id = $category, debit = $amount, credit = 0, recon_id = 1, memo = '$memo' WHERE transaction_id=$transid;";    
        } else {
            $query = "UPDATE $usertable SET transdate = '$trans_date', payee = '$payee_field', category_id = $category, debit = 0, credit = $amount, recon_id = 1, memo = '$memo' WHERE transaction_id=$transid;";
        }
        
        $result = mysqli_query($dbc, $query); 
        $ar = mysqli_affected_rows($dbc);
        
        if ($result && ($ar>0) ) {
            print '<p>Data inserted into database</p>';      
        } else {
            print '<p style="color: red;">Could execute query due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>";
            print "<p>Query = $query</p>";
            print "Affected rows = $ar";
        }
    } else {
        print "<p>Could not select database due to MYSQL ERROR: " . mysqli_error($dbc) . "</p>";
    }
    mysqli_close($dbc);
    print "<p>Please <a href='$return.php'>Continue</a></p>";
} else {
    print '<p style="color: red;">Could not connect to database server.</p>';
}
    
?>          
		</div>
		<div class="one_fourth">
			&nbsp;
		</div>
		<div class="resetColumnSet"></div>	
	</div>
</div>
</section>
    
</body>
</html>
