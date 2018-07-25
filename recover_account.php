<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracker -- Recover Account Data Submitted</title>
<link href="./css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="./css/mobile/layout.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="getMedia();">
<?php 
include("header.php");
include("mysqlnfo.php");

$hash = $_GET["hash"];

	if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    // Select database
    if (mysqli_select_db($dbc,"MFT_DB" )) {
		$query = "SELECT * FROM Recovery WHERE hash='$hash';";
        $result = mysqli_query($dbc, $query);
                
        if ($result) {
            $row = mysqli_fetch_row($result);
            $num_rows = mysqli_num_rows($result);
            if ($num_rows == 1) {
                $username = $row[1];
                $expire = $row[3];
                $temppass = $row[6];
                $now = date("Y-m-d h:i:s");
                
                if ($now > $expire) {
                    $message = "Sorry, $username,<BR>The period to change your password has expired.  Please go through the recovery process again by clicking <a href='recover_account.html'>Recover Account</a>";
                } else {
                    $message = "Welcome $username,<BR>Your temporary password is <span style='color:red;'>$temppass</span> (8 characters).<BR>Please <a href='login.html'>Login</a> with the temporary password.  You will be required to change your password once you login.";
                        
                    $query2 = "UPDATE Users SET change_pw=1, password='$hash' WHERE username='$username';";
                    $result = mysqli_query($dbc, $query2);
                    if ($result) {
                        $row = mysqli_fetch_row($result);
                        $num_rows = mysqli_num_rows($result);
                        if ($num_rows==1) {
                            // For now
                            $message = $message . "INSERT COMPLETE.";
                        }
                    } else {
                        die ("Error: " . mysqli_error($dbc));
                        
                    }
                }
                
            } else {
                $message = "Invalid hash.  Please go through the recovery process again by clicking <a href='recover_account.html'>Recover Account</a>";
            }
        }
		mysqli_close($dbc);	
    }
}
?>
	<script src="js/debug.js"></script>
	<h1>Money Finance Tracker -- Recover account details</h1>
	<div class="register_form_grid">
<!---------- Next Row ------------------------------------------------------------------->  
        <p>&nbsp;</p>
        <p>
        <?php echo $message; ?>
        </p>
        <div>
        &nbsp;
        </div>
<!---------- Next Row ------------------------------------------------------------------->
        <p>&nbsp;</p>
        <p>
        &nbsp;
        </p>
        <div>
        &nbsp;
        </div>
	</div>
	<img class="main-image" src="images/calculator.jpg" alt="Money Finance Tracker - Register Page image of a calculator">
	<p id="data">Data here</p>
</body>
</html>
