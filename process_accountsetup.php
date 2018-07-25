<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracking -- Accounts Process Page</title>
<link href="css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="css/mobile/layout.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    
<?php
include("header_secure.php");
include('mysqlnfo.php');
include("utility.php");

?>
    
<section id="Main-Page">
<div id="main-page-content">
	<div id="main-page-content_container">
		<div class="three_fourth">
<?php
	//$username = $_POST["username"];
	//User is logged in at this point
    //
if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    // Select database
    if (mysqli_select_db($dbc, $userdb)) {
        print "<p>Database selected successfully.</p>";
        
        $accountname=htmlentities($_POST['accountname']);
        $accountname=mysqli_real_escape_string($dbc, $accountname);
        $startingbalance=$_POST['starting_balance'];
        $startbaldate=$_POST['starting_balance_date'];
		$usertable = createusertable();
        
        $query = "INSERT INTO Accounts (accountname, startbaldate, startingbalance, usertable) VALUES ('$accountname','$startbaldate',$startingbalance, '$usertable');";
        $result = mysqli_query($dbc, $query); 
                
        if ($result) {
            print '<p>Data inserted into database</p>';      
        } else {
            print '<p style="color: red;">Could execute query due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>";
        }
		
		$query = "CREATE TABLE $usertable (" .
                 'transaction_id INT NOT NULL AUTO_INCREMENT,' .
                 'transdate DATE NOT NULL,' .
                 'payee VARCHAR(255) NOT NULL,' .
                 'category_id INT NOT NULL,' .
                 'debit DOUBLE NOT NULL,' .
                 'credit DOUBLE NOT NULL,' . 
                 'recon_id INT NOT NULL,' .
                 'memo VARCHAR(512),' .
                 'FOREIGN KEY (category_id) ' .
                 'REFERENCES Categories(cat_id) ' .
                 'ON DELETE CASCADE,' .
                 'PRIMARY KEY ( transaction_id )' .
                 ');';
                
                $result = mysqli_query($dbc, $query);
                 if (!$result) {
                    die('<p style="color: red;">' . "UNABLE to CREATE table ($usertable) due to MYSQL ERROR:" . mysqli_error($dbc) . "</p>");   
                }
    } else {
        print "<p>Could not select database due to MYSQL ERROR: " . mysqli_error($dbc) . "</p>";
    }
    mysqli_close($dbc);
    print "<p>Please <a href='main.php'>Continue</a></p>";
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
