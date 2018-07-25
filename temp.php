<?php
                      
//Show login or logout
if ($loggedin == 0) {
    print '<o><a href="./login.html">Login</a></p>';
} else {
    print '<p><a href="./logout.php">Logout</a><BR>You are logged in as <strong>' . $username . '</strong></p>';
    print '<p>Access the <a href="admin.php">Admin Page</a></p>';
    print '<p>Access the <a href="viewmessages.php">View Messages</a></p>';
}

            
?>