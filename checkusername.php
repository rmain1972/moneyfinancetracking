<?php
$username = $_GET["username"];

include('mysqlnfo.php');

    //
if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    // Select database
    if (mysqli_select_db($dbc, 'MFT_DB')) {
        
        $query = "SELECT * FROM Users WHERE username='$username';";
        $result = mysqli_query($dbc, $query);
        
        if ($result) {
            $num_rows = mysqli_num_rows($result);
            if ($num_rows==1) {
                print "EXISTS";    
            } else {
                print "NOT PRESENT";    
            }               
        } else {
            print "<p>Query unsuccessful due to MYSQL ERROR: " . mysqli_error($dbc) . "</p>";  
        }
    } else {
        print "<p>Could not select database due to MYSQL ERROR: " . mysqli_error($dbc) . "</p>";
    }
    mysqli_close($dbc);
} else {
    print '<p style="color: red;">Could not connect to database server.</p>';
}

?>