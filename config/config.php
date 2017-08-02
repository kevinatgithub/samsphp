<?php

$host		="localhost"; 	// Host name 
$username	="root"; 		// Mysql username 
#$password	="g0g0@dmin"; 		// Mysql password 
$password	=""; 		// Mysql password 
$db_name	="sams"; 	// Database name 

$con = mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db($con,"$db_name")or die("Cannot connect to database");


session_start();
$_fullname = isset($_SESSION['name']) ? $_SESSION['name'] : null;
$_username = isset($_SESSION["username"]) ? $_SESSION["username"] : null;

define("FULLNAME",$_fullname);
define("USER_NAME",$_username);

function GetDTRTimeEntry($employee_id,$year,$month,$day,$type,$override){
	global $con;
	if(array_key_exists($type, $override) !== false){
		return str_pad($override[$type]->time, 5, '0', STR_PAD_LEFT);
	}else{
		$am1 = mysqli_query($con,"SELECT time FROM log 
		WHERE employee_id = '".$employee_id."'
			AND year = ".$year."
			AND month = ".$month."
			AND day = ".$day."
			AND type = ".$type." 
			ORDER BY ID DESC");
		
		$row_am1 = @mysqli_fetch_assoc($am1);

		if($row_am1['time'] == ''){
			return '&nbsp;'; 
		}else{
			return date("h:i", strtotime($row_am1['time']));
		}

	}
}


function checkAccess(){
	if(USER_NAME != null || USER_NAME != ""){
		return true;
	}else{
		session_destroy();
		header("location:index.php");
		exit;
	}
}
?>