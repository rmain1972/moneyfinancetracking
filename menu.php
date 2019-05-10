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
    </div>
</body>
</html>
