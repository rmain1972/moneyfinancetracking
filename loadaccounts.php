<?php
// With ajax calls
if (session_status()==1) {
    session_start(); 
}

include("noheader_secure.php");
include("mysqlnfo.php");
include("utility.php");

$buildstr = "";

//$userdb set in noheader_secure.php

if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    // Select database
    if (mysqli_select_db($dbc, $userdb)) {
		
		$query = "SELECT * FROM Accounts;";
		$result = mysqli_query($dbc, $query);
		
		if ($result) {
            if (mysqli_num_rows($result)===0) { 
                $buildstr = "<p> Please create a tranasctional account by clicking 'Add Account' below in the lower left </p>";
            } else {
                
                while($row=mysqli_fetch_array($result)) {
                    $buildstr = $buildstr . "<p id='account-$row[0]' class='account_item";
                    if ($default_account==$row[0]) {
                        $buildstr = $buildstr . " selected";
                    }
                    $buildstr = $buildstr . "' onclick='loadtrans($row[0]), $default_mode'>$row[1]</p>";    
                }
        }
        print $buildstr;
        }
                
		} else {
                print '<p style="color: red;">Could execute query [loadtransactions.php] due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>";
        }
        
}

?>
