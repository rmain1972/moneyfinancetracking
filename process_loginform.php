<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracking -- Registration Process Page</title>
<link href="css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="css/mobile/layout.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<?php
	$username = htmlentities($_POST["username"]);
    $password = htmlentities($_POST["userpassword"]);
    
require_once("Mobile_Detect.php");
include('mysqlnfo.php');

    //
if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    $username = mysqli_real_escape_string($dbc, $username);
    $password = mysqli_real_escape_string($dbc, $password);
    // Select database
    if (mysqli_select_db($dbc, 'MFT_DB')) {
        $query = "SELECT password, database_name, change_pw, last_logon FROM Users WHERE username='$username';";
        $result = mysqli_query($dbc, $query); 
                
        if ($result) {
            $row = mysqli_fetch_row($result);
            
            if (password_verify($password, $row[0])) {
                if ($row[2] == 1) {
                    $_SESSION["loggin_status"] = "0";
                    header("Location: change_password.php?username=$username");
                } else {
                    // Set session variables
                    $_SESSION["username"] = $username;
                    $_SESSION["loggin_status"] = 1;
                    $_SESSION["user_database"] = $row[1];
                    $_SESSION["default_account"] = 1;
                    
                    $detect = new Mobile_Detect;
 
                    // Any mobile device (phones or tablets).
                    if ( $detect->isMobile() ) {
                        $_SESSION["default_mode"] = 2;
                    } else {
                        $_SESSION["default_mode"] = 1;  
                    }
                                    
                    $time = strtotime($row[3]);
                    $_SESSION["last_logon"] = date("m/d/y g:i A", $time);
                    $now = date('Y-m-d H:i:s');
                    $query = "UPDATE Users SET last_logon='$now' WHERE username='$username'";
                    $result = mysqli_query($dbc, $query);
                    if (!$result) {
                        die('<p style="color: red;">UPDATE did not run (last_logon) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");
                    }
                    header("Location: main.php");    
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
<body>
    
<section id="Main-Page">
<div id="main-page-content">
	<div id="main-page-content_container">
		<div class="three_fourth">
        <?php 
        if ($_SESSION["loggin_status"] == 0) {
            print "<p>Passwords do not match. Try again.</p>";
            print "<a href='login.html'>Login</a>";
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
