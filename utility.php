<?php
/* This file holds utility functions for MFT */


if (session_status()==1) {
	session_start();
}

// Active assert and make it quiet
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_QUIET_EVAL, 1);

// Create a handler function
function my_assert_handler($file, $line, $code, $desc = null)
{
    echo "Assertion failed at $file:$line: $code";
    if ($desc) {
        echo ": $desc";
    }
    echo "\n";
}

// Set up the callback
assert_options(ASSERT_CALLBACK, 'my_assert_handler');

/*

Source for this function was taken from
https://iwantsourcecodes.com/random-password-generator-in-php-source-code/

*/

function randCode($length = 5) {
$ranges = array(range('a', 'z'), range('A', 'Z'), range(0, 9));
$code = '';
    for($i = 0; $i < $length; $i++){
        $rkey = array_rand($ranges);
        $vkey = array_rand($ranges[$rkey]);
        $code .= $ranges[$rkey][$vkey];
    }
    
return $code;
    
}


function getuserdb() {
	$username = $_SESSION['username'];
	
    include("mysqlnfo.php");
    
	if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    // Select database
    if (mysqli_select_db($dbc,"MFT_DB" )) {
		$query = "SELECT database_name FROM Users WHERE username='$username';";
        $result = mysqli_query($dbc, $query);
		$userdb = "";
                
        if ($result) {
            $row = mysqli_fetch_row($result);
			$userdb = $row[0];
		}
		mysqli_close($dbc);
		
		return $userdb;
}
}
}

function getuseremail($email) {

include('mysqlnfo.php');

if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    // Select database
    if (mysqli_select_db($dbc, 'MFT_DB')) {
        
        $query = "SELECT * FROM Users WHERE email='$email';";
        $result = mysqli_query($dbc, $query);
        
        if ($result) {
            $num_rows = mysqli_num_rows($result);
            if ($num_rows==1) {
                return "EXISTS";    
            } else {
                return "NOT PRESENT";    
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
}

function isDuplicateEmail($email) {
    $result = getuseremail($email);
    if ($result == "EXISTS") {
        return true;
    } else {
        return false;
    }
}

function getuser_last_logon() {
	$username = $_SESSION['username'];
	
    include("mysqlnfo.php");
    
	if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    // Select database
        if (mysqli_select_db($dbc,"MFT_DB" )) {
		  $query = "SELECT last_logon FROM Users WHERE username='$username';";
            $result = mysqli_query($dbc, $query);
		  $ll = "";
                
            if ($result) {
                $row = mysqli_fetch_row($result);
                $ll = $row[0];
		  }
		  mysqli_close($dbc);
            
        $time = strtotime($ll);
        return date("m/d/y g:i A", $time);
            
        }    
    }
}

// For Now -- Should be run when add/delete/edit transaction
function updatebalances($account) {
    try {
     
        //$userdb set in noheader_secure.php
        include("noheader_secure.php");
        include("mysqlnfo.php");
        
        $si = new AccountInfo($account);
        $usertable = $si->UserTable;
        $balance = $si->StartingBalance;

        assert(($usertable === NULL), 'UserTable is NULL!');
        
        if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
        // Select database
        if (mysqli_select_db($dbc, $userdb)) {
		
		  $query = "SELECT * FROM $usertable ORDER BY transdate, debit, credit;";
		  $result = mysqli_query($dbc, $query);
		
		  if ($result) {
                if (mysqli_num_rows($result)===0) {
                die("<BR><p> Please add a transaction. </p>");
            } else {
                while($row=mysqli_fetch_array($result)) {
				// Build Sub row 1
                $transid=$row[0];
                				
				//Add calc here to calculate balance
                $balance = number_format((float)$balance + (float)$row[5] - (float)$row[4],2,'.','');
                    
                $query_update_balance = "UPDATE $usertable SET Balance = $balance WHERE transaction_id=$transid;";
			    $result2 = mysqli_query($dbc, $query_update_balance);
                if ($result2) {
                    //Do nothing
                } else {
                    print '<p style="color: red;">Could not execute query2 [utility.php - ] due to MYSQL ERROR:' . mysqli_error($dbc) . "<br>$query</p>";

                }
                }    
            }
		} else {
                print '<p style="color: red;">Could not execute query [utility.php - ] due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>";
        }
	    }
        }
        } catch(Exception $err) {
            die("<p>Error: $err</p>");
        }
}
    
function createusertable() {
    include("mysqlnfo.php");
	$usertable = "trans_T";
	$userdb = getuserdb();
	if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    // Select database
    if (mysqli_select_db($dbc, $userdb)) {

	$query = "SELECT tbluser_num FROM UtilityTableVar WHERE util_id=1;";
    $result = mysqli_query($dbc, $query);
	$tblnum = "";
			
	if ($result) {
		$row = mysqli_fetch_row($result);
		$tblnum = $row[0];
		$usertbl_update = $row[0];
        $usertbl_update++;
        $query = "UPDATE UtilityTableVar SET tbluser_num=$usertbl_update WHERE util_id=1;";
        $result = mysqli_query($dbc, $query);
        if (!$result) {
            die('<p style="color: red;">UPDATE did not run (tbluser_num) due to MYSQL ERROR:' . mysqli_error($dbc) . "</p>");
        }
	}
    
	mysqli_close($dbc);
	return $usertable . $tblnum;
}
}
}

function getusertable($account) {
    include("mysqlnfo.php");
	$userdb = getuserdb();
	$query = "SELECT usertable FROM Accounts WHERE account_id=$account;";
	
	if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    // Select database
    if (mysqli_select_db($dbc, $userdb)) {
		$result = mysqli_query($dbc, $query);
		if ($result) {
			$row = mysqli_fetch_row($result);
			$usertable = $row[0];
		}
	}
	mysqli_close($dbc);
	return $usertable;
	}
}

function dayofweek($date1) {
    $dowtime = strtotime($date1);
    return date("D",$dowtime);
}

function pcf($date1) {
    //Previous - Current -- Future
    $transdate = date("Y-m-d",strtotime($date1));
    $today = date("Y-m-d");

    if ($transdate < $today) { 
        return "prior_day";
    }

    if ($transdate == $today) {
        return "current_day";
    }
    
    if ($transdate > $today) {
        return "future_day";
    }
}

class CategoryData {
    
    public $CategoryName = 'Undefined';
    public $CategoryType = 'Income';
    
    function __construct($id) {
    include("mysqlnfo.php");
    $userdb = getuserdb();
    $query = "SELECT * FROM Categories WHERE cat_id=$id;";
	
	if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
        // Select database
        if (mysqli_select_db($dbc, $userdb)) {
		
		  $result = mysqli_query($dbc, $query);
		      if ($result) {
			     $row = mysqli_fetch_row($result);
			     $this->CategoryName = $row[1];
                 if ($row[2]==1) {
                        $this->CategoryType = "Income";    
                    } else {
                        $this->CategoryType = "Expense";
                    }      
		          }
	           }
	   mysqli_close($dbc);
	   }    
    }   
}

class AccountInfo {
    
    public $Name;
    public $StartingDate;
    public $StartingBalance;
    public $UserTable;
    
    function __construct($accountid) {
        include("mysqlnfo.php");
        $userdb = getuserdb();
	    $query = "SELECT * FROM Accounts WHERE account_id=$accountid;";
	
	if ($dbc = mysqli_connect('localhost', $mysql_user, $mysql_password)) {
    // Select database
    if (mysqli_select_db($dbc, $userdb)) {
		
		$result = mysqli_query($dbc, $query);
		if ($result) {
			$row = mysqli_fetch_row($result);
			$this->UserTable = $row[4];
            $this->Name = $row[1];
            $this->StartingDate = $row[2];
            $this->StartingBalance = $row[3];
		}
	}
	mysqli_close($dbc);
	}
    }
}

$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getOS() { 

    global $user_agent;

    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function getBrowser() {

    global $user_agent;

    $browser        = "Unknown Browser";

    $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}

function generate_password($length = 20){
  $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
            '0123456789`-=~!@#$%^&*()_+,./<>?;:[]{}\|';

  $str = '';
  $max = strlen($chars) - 1;

  for ($i=0; $i < $length; $i++)
    $str .= $chars[random_int(0, $max)];

  return $str;
}

function getReadableReconcileCode($reconcileint) {
    switch($reconcileint) {
        case 1:
            return "&nbsp;";
            break;
            
        case 2:
            return "✔";
            break;
            
        case 3:
            return "R";
            break;
            
        default:
            return "E";
            break;
    }
}

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

?>