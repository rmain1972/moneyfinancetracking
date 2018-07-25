<?php
if (session_status()==1) {
    session_start(); 
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracker -- Delete Transaction Page</title>
<link href="./css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="./css/mobile/layout.css" rel="stylesheet" type="text/css">
</head>

<?php
    include("noheader_secure.php");
    include('mysqlnfo.php');
    include("utility.php");
    
    $transid = $_GET["transid"];
    $return = $_GET["return"];
    $usertable = getusertable($_GET['account']);

    if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    // Select database
        if (mysqli_select_db($dbc, $userdb)) {
            $query = "DELETE FROM $usertable WHERE transaction_id=$transid;";
            $result = mysqli_query($dbc, $query);
            $ar = mysqli_affected_rows($dbc);
        
            if ($result && ($ar>0)) {
                //Do Nothing other than reload main.php
                header("Location: $return.php");
            } else {
                print '<p style="color: red;">Could execute query due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>";
                print "<p>Query = $query</p>";
                print "<p>Affected Rows=$ar</p>";
            }   
        } else {
        print "<p>Could not select database due to MYSQL ERROR: " . mysqli_error($dbc) . "</p>";
    }
    mysqli_close($dbc);
} else {
    print '<p style="color: red;">Could not connect to database server.</p>';
}

if (!$continue) {
    die("Unable to read database row ... edit_transaction.php");
} 
?>
<body>
	<h1>Money Finance Tracker -- Delete Transaction Page</h1>
    <p>Error if here!</p>
</body>
</html>