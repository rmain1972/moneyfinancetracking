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
            
    require_once('./vendor/autoload.php');
    use Postmark\PostmarkClient;
    
    include('mysqlnfo.php');
    include("sqlutil.php");
    include("utility.php");        
            
	$username = $_POST["username"];
    $email = $_POST["email"];
	$temp_password = randCode(9);
    $pwhash = password_hash($temp_password, PASSWORD_DEFAULT);
	
	print "Your username is $username";
	print "<BR>Your email is $email";
            
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
            
    //TODO: Prevent Duplicate email
    if (isDuplicateEmail($email)) {
        header("location: duplicate_email.php?email=$email");
        die("<p>&nbsp</p>");
    }
            

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
        $nows = strtotime($now);
        $expire = date('Y-m-d H:i:s', strtotime('+7 days', $nows));
        $query = "INSERT INTO Users (username, password, email, database_name, expire_date, create_date, change_pw) VALUES
        ('$username', '$pwhash', '$email', '$dbuser_db', '$expire', '$now', 1);";
        
        if (mysqli_query($dbc, $query)) {
             $client = new PostmarkClient("f1d91cb7-b9b9-417f-8b9c-a687f5df9356");

            // Send an email:
            $sendResult = $client->sendEmailWithTemplate(
            "noreply@moneyfinancetracking.com",
            "$email",
            11487713,
            [
                "product_name" => "Money Finance Tracking dot com",
                "name" => "$username",
                "product_url" => "https://test.moneyfinancetracking.com",
                "action_url" => "https://test.moneyfinancetracking.com/activate_account.php?username=$username",
                "login_url" => "https://test.moneyfinancetracking.com/login.html",
                "username" => "$username",
                "activate_code" => "$temp_password",
                "trial_length" => "7 days",
                "trial_start_date" => "$now",
                "trial_end_date" => "$expire",
                "support_email" => "rmain1972@live.com",
                "sender_name" => "MFT Webmaster",
                "help_url" => "https://test.moneyfinancetracking.com/help.php",
                "company_name" => "Rose Web Design LLC",
                "company_address" => "21900 SE 15th St, Harrah OK 73045",
                "live_chat_url" => "https://error.html",
            ]);
            
            print "<p>Activation code and instructions sent to your email.  Please check your email.</p>";
            
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
