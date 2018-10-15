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
}
           
?>
</div>
</div>
</header>