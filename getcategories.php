<?php
// With ajax calls
if (session_status()==1) {
    session_start(); 
}

$loggedin = $_SESSION['loggin_status'];
$username = $_SESSION['username'];
$userdb = $_SESSION['user_database'];

$account=$_GET["account"];
$setcat=$_GET["setcat"];

include('mysqlnfo.php');

if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    // Select database
    if (mysqli_select_db($dbc, $userdb)) {
        
        $query = "SELECT * FROM Categories;";
        $result = mysqli_query($dbc, $query);
        
        if ($result) {
            $buildstr = "";
            while($row=mysqli_fetch_array($result)) {
                if ($setcat==$row[0]) {
                    $buildstr = $buildstr . '<option selected value="' . $row[0] .'" class="';
                } else {
                    $buildstr = $buildstr . '<option value="' . $row[0] .'" class="';    
                }
                
                if ($row[2]==1) {
                    $buildstr = $buildstr . 'income_category_item">';
                } else {
                    $buildstr = $buildstr . 'expense_category_item">';
                }
                $buildstr = $buildstr . $row[1] . '</option>';
            }
            print $buildstr;
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