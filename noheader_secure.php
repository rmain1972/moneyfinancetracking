<?php
            
// Set Error Level and display errors
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (!isset($_SESSION['loggin_status'])) {
    $_SESSION["loggin_status"]=0;
    $_SESSION["username"]="";
    $_SESSION['user_database']="";
    $_SESSION["default_account"] = "";
} 

$loggedin = $_SESSION['loggin_status'];
$username = $_SESSION['username'];
$userdb = $_SESSION['user_database'];
$default_account = $_SESSION["default_account"];
    
?>

<?php
                      
//Show login or logout
if ($loggedin == 0) {
    print '<header><div class="header_grid">' .
         '<!---------------- Row 1 ------------------------>' .
         '<img src="images/logo.png" alt="Money Finance Tracking Logo">' .
         '<h1>Money Finance Tracking</h1>' .
         '<div>' .
         '<p>Session Expired ... please <a href="./login.html">Login</a></p>' .
         '</div>' .
         '</div>' . 
         '</header>';
    die('');
} else {
    //do nothing
}
            
?>
