<?php
            
// Set Error Level and display errors
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (!isset($_SESSION['loggin_status'])) {
    $_SESSION["loggin_status"]=0;
    $_SESSION["username"]="";
}

$loggedin = $_SESSION['loggin_status'];
$username = $_SESSION['username'];
$userdb = $_SESSION['user_database'];
$default_account = $_SESSION["default_account"];
    
if ($loggedin == 0) {
    header('Location: login.html');
}
?>
<header>
<div class="header_grid">
<!---------------- Row 1 ------------------------>
<img src="images/logo.png" alt="Money Finance Tracking Logo">
<h1>Money Finance Tracking</h1>
<div>
<?php
                      
//Show login or logout
if ($loggedin == 0) {
    print '<o><a href="./login.html">Login</a></p>';
} else {
    print '<p><a href="./logout.php">Logout</a><BR>You are logged in as <strong>' . $username . '</strong></p>';
    print '<BR>';
    print '<p2>Last Login:' . $_SESSION['last_logon'] .  '</p2>';
}
            
?>
</div>
</div>
</header>