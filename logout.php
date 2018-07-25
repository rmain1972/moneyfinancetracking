<?php
// Initialize the session.
session_start();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

header('Location: login.html');
           
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracker -- Home Page</title>
<link href="css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="css/mobile/layout.css" rel="stylesheet" type="text/css">
</head>

<body>
	<h1>Money Finance Tracker -- Logout Page</h1>
	<p>This this is the logout page, and shoud redirect to the login page.  Please send any comments/errors to <a href="mailto:rmain1972@live.com">rmain1972@live.com</a></p>
    <p><a href="login.html">Login</a></p>
	<img class="main-image" src="images/checkbook.jpg" alt="Money Finance Tracker - Logout Page - image of a checkbook">
</body>
</html>