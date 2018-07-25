<?php
    if (session_status()==1) {
    session_start(); 
}

    $oldpass = $_POST["oldpassword"];
    $newpass = $_POST["newpassword"];
    $confirm = $_POST["userpass2"];
    $username = htmlentities($_POST["username"]);
    $error = "";
    $_SESSION["loggin_status"] = "0";

    include('mysqlnfo.php');

    //
if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
     $username = mysqli_real_escape_string($dbc, $username);
    // Select database
    if (mysqli_select_db($dbc, 'MFT_DB')) {
        $query = "SELECT password, database_name, change_pw FROM Users WHERE username='$username';";
        $result = mysqli_query($dbc, $query); 
                
        if ($result) {
            $row = mysqli_fetch_row($result);
            
            if (password_verify($oldpass, $row[0])) {
                //Change password
                $pwhash = password_hash($newpass, PASSWORD_DEFAULT);
                $query2 = "UPDATE Users SET change_pw = 0, password = '$pwhash' WHERE username='$username';";
                $result2 = mysqli_query($dbc, $query2); 
                $error = $query2;
                if ($result2) {
                    header("location: login.html");
                } else {
                    $error = "Something went wrong setting new password.";
                }
            } else {
                $_SESSION["loggin_status"] = "0";
            }   
        } else {
            print '<p style="color: red;">Could not enter data into the database due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>";
        }
    } else {
        print "<p>Could not select database due to MYSQL ERROR: " . mysqli_error($dbc) . "</p>";
    }
    mysqli_close($dbc);
} else {
    print '<p style="color: red;">Could not connect to database server.</p>';
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracker -- Process Change Password</title>
<link href="./css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="./css/mobile/layout.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="getMedia();">
	<script src="js/debug.js"></script>
<?php
//include("header.php");    
?>
    
	<h1>Money Finance Tracker -- Process Change Password</h1>
    
	<div class="register_form_grid">
<!---------- Next Row ------------------------------------------------------------------->
        <p>&nbsp;</p>
        <p><?php echo $error ?></p>
        <div>
        &nbsp;
        </div>

	</div>
	<img class="main-image" src="images/calculator.jpg" alt="Money Finance Tracker - Register Page image of a calculator">
	<p id="data">Data here</p>
</body>
</html>


?>