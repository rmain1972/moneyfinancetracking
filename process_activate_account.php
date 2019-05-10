<?php
if (session_status()==1) {
    session_start(); 
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracker -- Process Activate Account</title>
<link href="css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="css/mobile/layout.css" rel="stylesheet" type="text/css">
<script src="js/activate.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
    require_once("Mobile_Detect.php");
    include("header.php");
    include('mysqlnfo.php');
    include("utility.php");
    
    $username = $_POST["username"];
    $activatecode = $_POST["activatecode"];
    
    if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
         $username = mysqli_real_escape_string($dbc, $username);
         $password = mysqli_real_escape_string($dbc, $activatecode);
        
         // Select database
        if (mysqli_select_db($dbc, 'MFT_DB')) {
            $query = "SELECT password, database_name, change_pw, last_logon, expire_date FROM Users WHERE username='$username';";
            $result = mysqli_query($dbc, $query);
            
            if ($result) {
                $row = mysqli_fetch_row($result);
                if (password_verify($password, $row[0])) {
                if ($row[2] == 0) {
                    $_SESSION["loggin_status"] = "0";
                    header("Location: login.html");
                } else {
                    // Check expire date
                    $now = date('Y-m-d H:i:s');
                    $nows = strtotime($now);
                    $expires = strtotime($row[4]);
                    
                    if ($expires > $nows) {
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
                        $updated_expire = date('Y-m-d H:i:s', strtotime('+365 days', $nows));
                        $query = "UPDATE Users SET last_logon='$now', expire_date='$updated_expire', change_pw=0 WHERE username='$username'";
                        $result = mysqli_query($dbc, $query);
                        if (!$result) {
                            die('<p style="color: red;">UPDATE did not run (last_logon, expire_date, change_pw) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");
                        } 
                        header("Location: change_password_on_activation.php?username=$username&code=$password");    
                    } else {
                        header("Location: expired.php");    
                    }    
                }   
                   
            } else {
                //Invalid Activation code
                $_SESSION["loggin_status"] = "0";
                header("location: invalid_activation_code.php?username=$username&code=$password");
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
	<h1>Money Finance Tracker -- Thank you for activating!</h1>
	<?php
    
    ?>
	<img class="main-image" src="images/calculator.jpg" alt="Money Finance Tracker - Register Page image of a calculator">
</body>
</html>