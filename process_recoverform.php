<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Money Finance Tracker -- Recover Account Data Submitted</title>
<link href="./css/desktop/layout.css" rel="stylesheet" type="text/css">
<link href="./css/mobile/layout.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="getMedia();">
<?php
    require_once('./vendor/autoload.php');
    use Postmark\PostmarkClient;
    
    include("utility.php");
    include("mysqlnfo.php");
    $useremail = $_POST["email"];
    
    if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    // Select database
    if (mysqli_select_db($dbc, 'MFT_DB')) {
        
        $query = "SELECT * FROM Users WHERE email='$useremail';";
        $result = mysqli_query($dbc, $query);
        
        if ($result) {
            $row=mysqli_fetch_array($result);
            $num_rows = mysqli_num_rows($result);
            if ($num_rows==1) {
                $username = $row[1];
                $useremail = $row[3];
                $d=strtotime("tomorrow");
                $expire_date = date("Y-m-d h:i:s", $d);
                $user_ip = $_SERVER["REMOTE_ADDR"];
                $http_user_agent = $_SERVER['HTTP_USER_AGENT'];
                $temppw = generate_password(8);
                $pwhash = password_hash($temppw, PASSWORD_DEFAULT);
                $query2 = "INSERT INTO Recovery (username, email, expire_date, user_ip, user_agent, temppass, hash) VALUES ('$username','$useremail','$expire_date','$user_ip','$http_user_agent', '$temppw','$pwhash' );";
                $result2 = mysqli_query($dbc, $query2);
                if($result === FALSE) { 
                    die(mysqli_error($dbc)); // TODO: better error handling
                }
                if ($result2) {                   
                    if (1 == 1) {
                        //Send Email
                    
                        $user_os        = getOS();
                        $user_browser   = getBrowser();
                    
                 
                        // Import the Postmark Client Class:

                        $client = new PostmarkClient("f1d91cb7-b9b9-417f-8b9c-a687f5df9356");

                        // Send an email:
                        $sendResult = $client->sendEmailWithTemplate(
                            "no-reply@moneyfinancetracking.com",
                            "$useremail",
                            6058281,
                            [
                            "product_name" => "Money Finance Tracking (MFT)",
                            "product_url" => "https://test.moneyfinancetracking.com",
                            "name" => "$username",
                            "action_url" => "https://test.moneyfinancetracking.com/recover_account.php?hash=$pwhash",
                            "operating_system" => "$user_os",
                            "browser_name" => "$user_browser",
                            "support_url" => "email:rmain1972@live.com",
                            "company_name" => "Rose Web Design LLC",
                            "company_address" => "21900 SE 15th St, Harrah, OK 73045",
                        ]);
                } else {
                    // 
                    echo "should not get here!";
                }
                } else {
                    print "<p>Query2 (process_recoverform.php) unsuccessful due to MYSQL ERROR: " . mysqli_error($dbc) . "</p>";    
                }   
            }               
        } else {
            echo "Send verify email address as no account found for email.";  
        }
    } else {
        print "<p>Could not select database due to MYSQL ERROR: " . mysqli_error($dbc) . "</p>";
    }
    mysqli_close($dbc);
} else {
    print '<p style="color: red;">Could not connect to database server.</p>';
}

?>
	<script src="js/debug.js"></script>
	<h1>Money Finance Tracker -- Recover account email submitted</h1>
	<div class="register_form_grid">
<!---------- Next Row ------------------------------------------------------------------->  
        <p>&nbsp;</p>
        <p>
        Your request has been processed.  Please check <?php echo $useremail; ?> for further instructions.
        </p>
        <div>
        &nbsp;
        </div>
<!---------- Next Row ------------------------------------------------------------------->
        <p>&nbsp;</p>
        <p>
        &nbsp;
        </p>
        <div>
        &nbsp;
        </div>
	</div>
	<img class="main-image" src="images/calculator.jpg" alt="Money Finance Tracker - image of a calculator">
	<p id="data">Data here</p>
</body>
</html>
