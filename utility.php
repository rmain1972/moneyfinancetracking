<?php
/* This file holds utility functions for MFT */


if (session_status()==1) {
	session_start();
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

?>