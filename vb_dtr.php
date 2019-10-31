<?php
	date_default_timezone_set('Asia/Manila');
	include "config/config.php";

	$employee_no = $_REQUEST['employee_no'];
	$year = $_REQUEST['year'];
	$month = $_REQUEST['month'] * 1;
	$cutoff = $_REQUEST['cutoff'];
	$signatory = $_REQUEST['signatory'];
	$position = $_REQUEST['position'];
	
	$saturdays_str = $_REQUEST['saturdays'];
	$saturdays = explode(",",$saturdays_str);
	
	$sundays_str = $_REQUEST['sundays'];
	$sundays = explode(",",$sundays_str);
	
	$mondays = $_REQUEST['mondays'];

	$holidays_str = $_REQUEST['holidays'];
	$holidays = explode(",",$holidays_str);
	
	$holidays_no_remarks = $_REQUEST['holidays_no_remarks'];

	$ot = isset($_REQUEST['ot']) ? $_REQUEST['ot'] : '';

	$absents_str = $_REQUEST['absents'];
	$absents = explode(",",$absents_str);

	$off_str = $_REQUEST['off'];
	$offs = explode(",",$off_str);

	$shifting_days_str = $_REQUEST['shifting_days'];
	$shifting_days = explode(",",$shifting_days_str);

	$half_days_str = $_REQUEST['half_days'];
	$half_days = explode(",",$half_days_str);
	$clear_entries = $_REQUEST['clear_entries'];

	// print_r($_REQUEST);

	$month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

	$employee = mysqli_query($con,"SELECT * FROM employee WHERE id = '$employee_no'");
	$row = @mysqli_fetch_array($employee);
	$employee_id = $row['id'];
	$print_month = strftime("%B",mktime(0,0,0,$month));

	switch ($cutoff){
		case 1:
			$print_cutoff = '1-15';
		break;
		case 2:
			$print_cutoff = '16-'.$month_days;
		break;
		case 3:
		default:
			$print_cutoff = '1-'.$month_days;
	}
	

	$filename = "ip_log.txt";
    $content = $_SERVER['REMOTE_ADDR']." | ".USER_NAME. " | {$employee_no} | {$year} | {$month} | {$cutoff} ". date('Y-m-d H:i:s')."\n"; 
    file_put_contents($filename, $content.PHP_EOL , FILE_APPEND | LOCK_EX);
?>
<!DOCTYPE html>
<html>
<head>
	<title>DTR</title>
	<link rel="stylesheet" type="text/css" href="css/export-dtr.css">
</head>
<body>
	<div class="container">
			<?php include("vb_dtr_column.php") ?>
	</div>
</body>
</html>