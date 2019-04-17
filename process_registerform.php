<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracking -- Registration Process Page</title>
<link href="css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="css/mobile/layout.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    
<section id="Main-Page">
<div id="main-page-content">
	<div id="main-page-content_container">
		<div class="three_fourth">
<?php
	$username = $_POST["username"];
    $email = $_POST["email"];
	$password = $_POST["userpassword"];
    $pwhash = password_hash($password, PASSWORD_DEFAULT);
	
	print "Your username is $username";
	print "<BR>Your email is $email";
    print "<BR>Your pwhash is $pwhash";
            
    if (($username=="") || ($email=="")) {
        $line = date('Y-m-d H:i:s') . " -- $_SERVER[REMOTE_ADDR] -- USERNAME/EMAIL BLANK -- $_SERVER[REQUEST_URI]";
        file_put_contents('errors.log', $line . PHP_EOL, FILE_APPEND);
        die("<BR><BR>Username and/or email cannot be blank!  This attempt has been recorded!");        
    }
            
    // Valid Email?
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $line = date('Y-m-d H:i:s') . " -- $_SERVER[REMOTE_ADDR] -- INCORRECT EMAIL FORMAT -- $_SERVER[REQUEST_URI]";
        file_put_contents('errors.log', $line . PHP_EOL, FILE_APPEND);
        die("<BR><BR>Invalid email format!  This attempt has been recorded!");  
    }
            
include('mysqlnfo.php');
include("sqlutil.php");

    //
if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    // Select database
    if (mysqli_select_db($dbc, 'MFT_DB')) {
        print "<p>Database selected successfully.</p>";
        
        $query = "SELECT dbuser_num FROM UtilityVar WHERE util_id=1;";
        $result = mysqli_query($dbc, $query);
        
        if ($result) {
            $row = mysqli_fetch_row($result);
            $dbuser_num = $row[0];
            $dbuser_db = "MFT_U" . $dbuser_num;
            $dbuser_update = $row[0];
            $dbuser_update++;
            $query = "UPDATE UtilityVar SET dbuser_num=$dbuser_update WHERE util_id=1;";
            $result = mysqli_query($dbc, $query);
            if (!$result) {
                die('<p style="color: red;">UPDATE did not run (dbuser_num) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");
            }
            
        } else {
            die('<p style="color: red;">Query did not run (dbuser_num) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>"); 
        }
        $now = date('Y-m-d H:i:s');
        $query = "INSERT INTO Users (username, password, email, database_name, expire_date, create_date) VALUES
        ('$username', '$pwhash', '$email', '$dbuser_db', '2018-03-01', '$now');";
        
        if (mysqli_query($dbc, $query)) {
            print "<p>Data entered successfully into the database.</p>";
            
            $to = "rmain1972@live.com";
            $subject = "User Added";
            $txt = "Details:\r\n" . "Username:$username\r\n" . "Email: $email on $now";
            $headers = "From: webmaster@moneyfinancetracking.com" . "\r\n";
            mail($to,$subject,$txt,$headers);

        } else {
            print '<p style="color: red;">Could not enter data into the database due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>";
        }
        
        
        
        /* CREATE USER DB */
        
        $query = "CREATE DATABASE $dbuser_db;";
        $result = mysqli_query($dbc, $query);
        
        if ($result) {
            if (mysqli_select_db($dbc, $dbuser_db)) {
                
                /* CREATE TABLES */
                $query = "CREATE TABLE Reconcile (recon_id INT NOT NULL AUTO_INCREMENT, name VARCHAR(255) NOT NULL, PRIMARY KEY ( recon_id ));";
                $result = mysqli_query($dbc, $query);
                if (!$result) {
                     die('<p style="color: red;">UNABLE to create table (Reconcile) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");  
                }
                
                $query1 = "INSERT INTO Reconcile (name) VALUES (' ');";
                $query2 = "INSERT INTO Reconcile (name) VALUES ('C');";
                $query3 = "INSERT INTO Reconcile (name) VALUES ('R');";
                
                $result = mysqli_query($dbc, $query1);
                 if (!$result) {
                     die('<p style="color: red;">UNABLE to INSERT into table (Reconcile-q1) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");  
                }
                
                $result = mysqli_query($dbc, $query2);
                 if (!$result) {
                     die('<p style="color: red;">UNABLE to INSERT into table (Reconcile-q2) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");  
                }
                
                $result = mysqli_query($dbc, $query3);
                 if (!$result) {
                     die('<p style="color: red;">UNABLE to INSERT into table (Reconcile-q3) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");  
                }
                
                $query = "CREATE TABLE CatType ( cattype_id INT NOT NULL AUTO_INCREMENT, name VARCHAR(255) NOT NULL, PRIMARY KEY ( cattype_id ) );";
                $result = mysqli_query($dbc, $query);
                if (!$result) {
                    die('<p style="color: red;">UNABLE to CREATE table (CatType) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");   
                }
                
                $query1 = 'INSERT INTO CatType (name) VALUES ("Income");';
                $query2 = 'INSERT INTO CatType (name) VALUES ("Expense");';
                
                $result = mysqli_query($dbc, $query1);
                if (!$result) {
                    die('<p style="color: red;">UNABLE to INSERT into (CatType-q1) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");   
                }
                
                $result = mysqli_query($dbc, $query2);
                if (!$result) {
                    die('<p style="color: red;">UNABLE to INSERT into (CatType-q2) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");   
                }

                $query = 'CREATE TABLE Accounts (' .
                         'account_id INT NOT NULL AUTO_INCREMENT,' .
                         'accountname VARCHAR(255) NOT NULL,' .
                         'startbaldate DATE NOT NULL,' .
                         'startingbalance DOUBLE NOT NULL,' .
						 'usertable VARCHAR(50) NOT NULL,' .
                         'PRIMARY KEY ( account_id )' .
                         ');';
                
                $result = mysqli_query($dbc, $query);
                if (!$result) {
                    die('<p style="color: red;">UNABLE to CREATE table (Accounts) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");   
                }
                
                /* Create Categories Table */
                
                $mysqli = new mysqli('localhost', $mysql_user, $mysql_password, $dbuser_db);
                sqlImport('Categories.sql');
                
                /* UtilityTableVar */
        
				$query = 'CREATE TABLE UtilityTableVar (' .
	                     'util_id INT NOT NULL AUTO_INCREMENT,' .
	                     'tbluser_num INT NOT NULL,' .
	                     'PRIMARY KEY (util_id)' .
					     ');';
				
				$result = mysqli_query($dbc, $query);
                 if (!$result) {
                    die('<p style="color: red;">UNABLE to CREATE table UtilityTableVar due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");  
					 
			     }
                
                $query = 'INSERT INTO UtilityTableVar (tbluser_num) VALUES (0);';
                $result = mysqli_query($dbc, $query);
                 if (!$result) {
                    die('<p style="color: red;">UNABLE to INSERT into table (UtilityTableVar) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");   
                }
        } else {
            die("<p style='color: red;'>UNABLE to CREATE DB ($dbuser_db) due to MYSQL ERROR:" . mysqli_error($dbc) . "</p>");     
        }
    } else {
        print "<p>Could not select database due to MYSQL ERROR: " . mysqli_error($dbc) . "</p>";
    }
    mysqli_close($dbc);
    print "<p>Please <a href='login.html'>login.</a></[p>]";
} else {
    print '<p style="color: red;">Could not connect to database server.</p>';
}
}
?>          
		</div>
		<div class="one_fourth">
			&nbsp;
		</div>
		<div class="resetColumnSet"></div>	
	</div>
</div>
</section>
    
</body>
</html>
