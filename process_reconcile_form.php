<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracking -- Reconcile Process Page</title>
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
    $userdb = $_SESSION['user_database'];
    if (mysqli_select_db($dbc, $userdb)) {
        print "<p>Database selected successfully.</p>";
        
        $usertable = getusertable($_POST['selected_account']);
        $json_data = $_POST['json_reconcile_data'];
        
        print $json_data;
        print "<HR>";
        $json_data = json_decode($json_data);
        var_dump($json_data);
        print "<HR>";
        
        while (list(, $item) = each($json_data->transactions)) {
            $item = substr($item, 6);
            echo $item . "<BR>";
            
            try {
                $query = "UPDATE $usertable SET recon_id=3 WHERE transaction_id=$item;";
                $result = mysqli_query($dbc, $query);
                
                if ($result) {
                    // Do Nothing!   
                } else {
                    throw new Exception('<p style="color: red;">Could execute query due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
             
        } 
            
        
        
                
        //if ($result) {
        //    print '<p>Data inserted into database</p>';      
        //} else {
        //    print '<p style="color: red;">Could execute query due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>";
        //}
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