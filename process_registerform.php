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
            
include('mysqlnfo.php');

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
        
        $query = "INSERT INTO Users (username, password, email, database_name, expire_date) VALUES
        ('$username', '$pwhash', '$email', '$dbuser_db', '2018-03-01');";
        
        if (mysqli_query($dbc, $query)) {
            print "<p>Data entered successfully into the database.</p>";   
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
            
                $query = 'CREATE TABLE Categories (' .
                         'cat_id INT NOT NULL AUTO_INCREMENT,' .
                         'name VARCHAR(255) NOT NULL,' .
                         'Cattype_id INT NOT NULL,' .
                         'FOREIGN KEY (Cattype_id)' .
                         'REFERENCES CatType(cattype_id)' .
                         'ON DELETE CASCADE,' .
                         'PRIMARY KEY ( cat_id )' .
                         ');';
                
                $result = mysqli_query($dbc, $query);
                if (!$result) {
                    die('<p style="color: red;">UNABLE to CREATE table (Categories) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");   
                }
                
                $query1 = 'INSERT INTO Categories (name, Cattype_id) VALUES ("Paycheck",1);';
                $query2 = 'INSERT INTO Categories (name, Cattype_id) VALUES ("Other Income",1);';
                
                $result = mysqli_query($dbc, $query1);
                 if (!$result) {
                    die('<p style="color: red;">UNABLE to INSERT into table (Categories-q1i) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");   
                }
                
                $result = mysqli_query($dbc, $query2);
                 if (!$result) {
                    die('<p style="color: red;">UNABLE to INSERT into table (Categories-q2i) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");   
                }
                
                 /* Expense Categories */
                $query1 = 'INSERT INTO Categories (name, Cattype_id) VALUES ("Utilities",2);';
                $query2 = 'INSERT INTO Categories (name, Cattype_id) VALUES ("Utilities:Electric",2);';
                $query3 = 'INSERT INTO Categories (name, Cattype_id) VALUES ("Utilities:Internet",2);';
                $query4 = 'INSERT INTO Categories (name, Cattype_id) VALUES ("Credit Card",2);';
                $query5 = 'INSERT INTO Categories (name, Cattype_id) VALUES ("Credit Card:Capital One",2);';
                $query6 = 'INSERT INTO Categories (name, Cattype_id) VALUES ("Miscellaneous Expense",2);';
                
                $result = mysqli_query($dbc, $query1);
                 if (!$result) {
                    die('<p style="color: red;">UNABLE to INSERT into table (Categories-q1e) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");   
                }
                
                $result = mysqli_query($dbc, $query2);
                 if (!$result) {
                    die('<p style="color: red;">UNABLE to INSERT into table (Categories-q2e) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");   
                }
                
                $result = mysqli_query($dbc, $query3);
                 if (!$result) {
                    die('<p style="color: red;">UNABLE to INSERT into table (Categories-q3d) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");   
                }
                
                $result = mysqli_query($dbc, $query4);
                 if (!$result) {
                    die('<p style="color: red;">UNABLE to INSERT into table (Categories-q4e) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");   
                }
                
                $result = mysqli_query($dbc, $query5);
                 if (!$result) {
                    die('<p style="color: red;">UNABLE to INSERT into table (Categories-q5e) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");   
                }
                
                $result = mysqli_query($dbc, $query6);
                 if (!$result) {
                    die('<p style="color: red;">UNABLE to INSERT into table (Categories-q6e) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");   
                }
				
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
