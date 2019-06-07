<?php
if (session_status()==1) {
    session_start(); 
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracker -- Main Menu</title>
<link href="css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="css/mobile/layout.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<?php
include("header_secure.php");
include("utility.php");
?>
<body>
	<h1>Money Finance Tracker -- Main Menu</h1>
	<div class="menu_grid">
    <!-- Option 1 -- Ledger -->
    <div class="menu_option"><a href="main.php">Open Ledgers</a></div>
    <!-- Option 2 -- Edit Catagories -->
    <div class="menu_option"><a href="editcats.php">Edit Categories</a></div>
    <!-- Option 3 -- change Password -->
    <div class="menu_option"><a href="change_password.php?username=<?php echo $_SESSION["username"]; ?>">Change Password</a></div>
    <!-- Option 4 -- Delete User Account -->
    <div class="menu_option"><a href="delete_user_account.php">Delete User Account</a></div>
    </div>
</body>
</html>
