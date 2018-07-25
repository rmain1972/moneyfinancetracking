<?php
// With ajax calls
if (session_status()==1) {
    session_start(); 
}

include("noheader_secure.php");
include("mysqlnfo.php");
include("utility.php");

$account = $_GET['account'];
$_SESSION["default_account"]=$account;

try {
    $si = new AccountInfo($account);

$buildstr = "";
$buildstr = $buildstr . "<div class='transaction_item'>";
				$buildstr = $buildstr . "<!----------- Sub Row 1 ------------------->";
                $dow = dayofweek($si->StartingDate);
                $buildstr = $buildstr . "<p class='tiday'>$dow</p>";
				$buildstr = $buildstr . "<p class='tipayee'>Starting Balance</p>";
				$buildstr = $buildstr . "<p class-'ticredit'>$si->StartingBalance</p><p class='tidebit'>&nbsp;</p>";
							
				//Add calc here to calculate balance
				$buildstr = $buildstr . "<p class='tibalance'>$si->StartingBalance</p>";
				
				$buildstr = $buildstr . "<p class='solid_box' onclick='toggle_checkmark()'>&nbsp;</p>";
                $buildstr = $buildstr . "<p>&nbsp;</p>";
				
				//Sub Row 2
				$buildstr = $buildstr . "<!-------------- Sub Row 2 --------------------->";
				$buildstr = $buildstr . "<p class='tidate'>$si->StartingDate</p>";
				$buildstr = $buildstr . "<p>&nbsp;</p>";
				$buildstr = $buildstr . "<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p class='timemo'>&nbsp;</p></div>";
    
if ($si->UserTable === NULL) {
    die("<p> Please create a transactional account. </p>");
}

$usertable = $si->UserTable;
$balance = $si->StartingBalance;
    

    

    
//$userdb set in noheader_secure.php

if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    // Select database
    if (mysqli_select_db($dbc, $userdb)) {
		
		$query = "SELECT * FROM $usertable ORDER BY transdate, debit, credit;";
		$result = mysqli_query($dbc, $query);
		
		if ($result) {
            if (mysqli_num_rows($result)===0) {
                $buildstr = $buildstr . "<BR><p> Please add a transaction. </p>";
            } else {
                while($row=mysqli_fetch_array($result)) {
				// Build Sub row 1
                $transid=$row[0];
                $day = $row[1];
                $pcf = pcf($day);
			    $buildstr = $buildstr . "<div id='trans-$transid' class='transaction_item $pcf'>";
				$buildstr = $buildstr . "<!----------- Sub Row 1 ------------------->";
                $dow = dayofweek($row[1]);
                $buildstr = $buildstr . "<p class='tiday'>$dow</p>";
				$buildstr = $buildstr . "<p class='tipayee'>$row[2]</p>";
				
				$cateogry = new CategoryData($row[3]);
				
                if ($cateogry->CategoryType == "Expense") {
				    $buildstr = $buildstr . "<p class='ticredit'>&nbsp;</p><p class='tidebit'>" . number_format((float)$row[4],2,'.','') . "</p>";
				} else {
				    $buildstr = $buildstr . "<p class='ticredit'>" . number_format((float)$row[5],2,'.','') . "</p><p class='tidebit'>&nbsp;</p>";
				}
                				
				//Add calc here to calculate balance
                $balance = number_format((float)$balance + (float)$row[5] - (float)$row[4],2,'.','');
				$buildstr = $buildstr . "<p class='tibalance'>$balance</p>";
				
				$buildstr = $buildstr . "<p id='check-$transid' class='solid_box' onclick='toggle_checkmark($transid)'>" . getReadableReconcileCode($row[6]) . "</p>";
                $buildstr = $buildstr . "<p onclick='edit($account, $transid)'>Edit</p>";
				
				//Sub Row 2
				$buildstr = $buildstr . "<!-------------- Sub Row 2 --------------------->";
				$buildstr = $buildstr . "<p class='tidate'>$row[1]</p>";
				$buildstr = $buildstr . "<p class='ticat'>$cateogry->CategoryName</p>";
				$buildstr = $buildstr . "<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p class='timemo'>$row[7]</p></div>";
                }    
            }
            print $buildstr;
            print "<div id='bottomoftrans'><hr></div>";
		} else {
                print '<p style="color: red;">Could execute query [loadtransactions.php] due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>";
        }
	}
}

} catch(Exception $err) {
    die("<p> Please create a transactional account. </p>");
}


/*
// For Now --
if ($loggedin == 1) {
print "<div class='transaction_item'>
		    <!-------------- Sub Row 1 ---------------------------------->
		          <p>Thurs</p>
		          <p>Vision Insurance (VCD)</p>
		          <p>&nbsp;</p>
		          <p>$44.82</p>
		          <p>TBD</p>
		          <p>&nbsp;</p>
		          <p>&nbsp;</p>
		    <!-------------- Sub Row 2 ---------------------------------->
		          <p>3-27-2018</p>
		          <p>Health</p>
		          <p>&nbsp;</p>
		          <p>&nbsp;</p>
		          <p>&nbsp;</p>
		          <p>&nbsp;</p>
		          <p>&nbsp;</p>
	       </div>
           <div class='transaction_item'>
		    <!-------------- Sub Row 1 ---------------------------------->
		          <p>Thurs</p>
		          <p>Delta Dental</p>
		          <p>&nbsp;</p>
		          <p>$38.00</p>
		          <p>TBD</p>
		          <p>&nbsp;</p>
		          <p>&nbsp;</p>
		    <!-------------- Sub Row 2 ---------------------------------->
		          <p>3-27-2018</p>
		          <p>Health</p>
		          <p>&nbsp;</p>
		          <p>&nbsp;</p>
		          <p>&nbsp;</p>
		          <p>&nbsp;</p>
		          <p>&nbsp;</p>
	       </div>";
}
*/
?>
