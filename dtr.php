<?php
	date_default_timezone_set('Asia/Manila');
	include "config/config.php";

	// checkAccess();

	$employee_no = $_REQUEST['employee_no'];
	$month = $_REQUEST['month'] * 1;
	$cutoff = $_REQUEST['cutoff'];
	$year = $_REQUEST['year'];
	$saturdays = $_REQUEST['saturdays'];
	$sundays = $_REQUEST['sundays'];
	$holidays = $_REQUEST['holidays'];
	$absents = $_REQUEST['absents'];
	$off = $_REQUEST['off'];


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

	$office_rs = mysqli_query($con,"SELECT * FROM office WHERE id = '".$row["office"]."'") or exit(mysqli_error($con));
	$signatory = "";
	if(mysqli_num_rows($office_rs)){
		$signatory = mysqli_fetch_object($office_rs)->signatory;
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
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
			<div class="left">
				<small>Civil Service Form No. 48</small>
				<center>
				<b><p style="font-size:12px;">DAILY TIME RECORD</p></b>
				</center>

				<table width="100%" class="subs">
					<tr>
						<td colspan="3" class="blank name"><?php print $row['fname'].' '.$row['mname'].' '.$row['lname']; ?></td>
					</tr>
					<tr>
						<td colspan="3"><small>N A M E</small></td>
					</tr>
					<tr>
						<td class="text-right">the month of </td>
						<td colspan="2" class="blank date"><?php print $print_month.' '.$print_cutoff.', '.$year; ?></td>
					</tr>
					<tr>
						<td width="40%" class="text-left" rowspan="2">Official hours for arrival and departure</td>
						<td class="text-right" width="30%">Regular Days</td>
						<td width="30%" class="blank">&nbsp;</td>
					</tr>
					<tr>
						<td class="text-right">Saturdays</td>
						<td class="blank">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="3" height="5"></td>
					</tr>
				</table>
				
				<table width="100%" class="main" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<th width="30" rowspan="2">DAY</th>
							<th colspan="2">A.M.</th>
							<th colspan="2">P.M.</th>
							<th colspan="2">Overtime</th>
						</tr>
					</thead>
					<tr>
						<th>&nbsp;</th>
						<th width="50">Arrival</th>
						<th width="50">Departure</th>
						<th width="50">Arrival</th>
						<th width="50">Departure</th>
						<th width="50">Arrival</th>
						<th width="50">Departure</th>
					</tr>
					<tbody>
					<?php

						if($cutoff == 1) {
							require "dtr_first_cutoff.php";									
						}elseif($cutoff == 2) {
							require "dtr_second_cutoff.php";
						}elseif($cutoff == 3) {
							require "dtr_fullmonth.php";
						}

					?>
					</tbody>
					<tr >
						<th style="border:none;"></th>
						<th style="border:none;font-size:12px;">TOTAL</th>
						<!-- <th colspan="2" style="border:none;border-bottom:3px solid #000;"></th> -->
						<th colspan="2" style="border-left:none;border-right:none;" class="blank name">&nbsp;</th>
						<th colspan="3" style="border:none;"></th>
					</tr>
					<tr>
						<th style="border:none;"></th>
						<th colspan="6" style="border:none;font-size:12px;text-align:left;text-transform:none;">
						<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							I CERTIFY on my honor that the above is a true<br/><br/> 
							and correct report of the hours of work performed, record<br/><br/>
							 of which was made daily at the time of arrival at and <br/><br/>
							departure from office.
						</th>
					</tr>
					<tr>
						<th style="border:none;"></th>
						<th colspan="6" style="border-left:none;border-right:none;border-top:none;height:30px;" class="blank name">&nbsp;</th>
					</tr>
					<tr>
						<th style="border:none;"></th>
						<th colspan="6" style="border:none;text-transform:none;font-size:12px;">Signature</th>
					</tr>
					<tr>
						<th style="border:none;"></th>
						<th colspan="6" style="border:none;text-transform:none;font-size:12px;"><br/><br/>
							Verified as to the prescribed office hours.
						</th>
					</tr>
					<tr>
						<th style="border:none;"></th>
						<th colspan="6" style="border-left:none;border-right:none;border-top:none;height:30px;" class="blank name">&nbsp;</th>
					</tr>
					<tr>
						<th style="border:none;"></th>
						<th colspan="6" style="border:none;text-transform:none;font-size:10px;font-weight:bold;font-size:12px;">
						MARITES B. ESTRELLA, RN, MM, MDM<br/>
						<i>Program Manager, NVBSP</i>
						</th>
					</tr>
				</table>
			</div>

			<div class="left" style="margin-left:3.1em;">
				<small>Civil Service Form No. 48</small>
				<center>
				<b><p style="font-size:12px;">DAILY TIME RECORD</p></b>
				</center>

				<table width="100%" class="subs">
					<tr>
						<td colspan="3" class="blank name"><?php print $row['fname'].' '.$row['mname'].' '.$row['lname']; ?></td>
					</tr>
					<tr>
						<td colspan="3"><small>N A M E</small></td>
					</tr>
					<tr>
						<td class="text-right">the month of </td>
						<td colspan="2" class="blank date"><?php print $print_month.' '.$print_cutoff.', '.$year; ?></td>
					</tr>
					<tr>
						<td width="40%" class="text-left" rowspan="2">Official hours for arrival and departure</td>
						<td class="text-right" width="30%">Regular Days</td>
						<td width="30%" class="blank">&nbsp;</td>
					</tr>
					<tr>
						<td class="text-right">Saturdays</td>
						<td class="blank">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="3" height="5"></td>
					</tr>
				</table>
				
				<table width="100%" class="main" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<th width="30" rowspan="2">DAY</th>
							<th colspan="2">A.M.</th>
							<th colspan="2">P.M.</th>
							<th colspan="2">Overtime</th>
						</tr>
					</thead>
					<tr>
						<th>&nbsp;</th>
						<th width="50">Arrival</th>
						<th width="50">Departure</th>
						<th width="50">Arrival</th>
						<th width="50">Departure</th>
						<th width="50">Arrival</th>
						<th width="50">Departure</th>
					</tr>
					<tbody>
					<?php

					if($cutoff == 1) {
						require "dtr_first_cutoff.php";
					}elseif($cutoff == 2) {
						require "dtr_second_cutoff.php";
					}elseif($cutoff == 3) {
						require "dtr_fullmonth.php";
					}

					?>
					</tbody>
					<tr >
						<th style="border:none;"></th>
						<th style="border:none;font-size:12px;">TOTAL</th>
						<!-- <th colspan="2" style="border:none;border-bottom:3px solid #000;"></th> -->
						<th colspan="2" style="border-left:none;border-right:none;" class="blank name">&nbsp;</th>
						<th colspan="3" style="border:none;"></th>
					</tr>
					<tr>
						<th style="border:none;"></th>
						<th colspan="6" style="border:none;font-size:12px;text-align:left;text-transform:none;">
						<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							I CERTIFY on my honor that the above is a true<br/><br/> 
							and correct report of the hours of work performed, record<br/><br/>
							 of which was made daily at the time of arrival at and <br/><br/>
							departure from office.
						</th>
					</tr>
					<tr>
						<th style="border:none;"></th>
						<th colspan="6" style="border-left:none;border-right:none;border-top:none;height:30px;" class="blank name">&nbsp;</th>
					</tr>
					<tr>
						<th style="border:none;"></th>
						<th colspan="6" style="border:none;text-transform:none;font-size:12px;">Signature</th>
					</tr>
					<tr>
						<th style="border:none;"></th>
						<th colspan="6" style="border:none;text-transform:none;font-size:12px;"><br/><br/>
							Verified as to the prescribed office hours.
						</th>
					</tr>
					<tr>
						<th style="border:none;"></th>
						<th colspan="6" style="border-left:none;border-right:none;border-top:none;height:30px;" class="blank name">&nbsp;</th>
					</tr>
					<tr>
						<th style="border:none;"></th>
						<th colspan="6" style="border:none;text-transform:none;font-size:10px;font-weight:bold;font-size:12px;">
						MARITES B. ESTRELLA, RN, MM, MDM<br/>
						<i>Program Manager, NVBSP</i>
						</th>
					</tr>
				</table>

			</div>
	</div>
	<script>
		var saturdays_str = <?=json_encode($saturdays)?>;
		var sundays_str = <?=json_encode($sundays)?>;
		var holidays_str = <?=json_encode($holidays)?>;
		var absents_str = <?=json_encode($absents)?>;
		var off_str = <?=json_encode($off)?>;

		var sats = saturdays_str.split(',');
		var suns = sundays_str.split(',');
		var hols = holidays_str.split(',');
		var abs = absents_str.split(',');
		var off = off_str.split(',');
		$(function(){
			sats.forEach(sat=>{
				modify(sat,'SATURDAY');
			});
			suns.forEach(sat=>{
				modify(sat,'SUNDAY');
			});
			hols.forEach(sat=>{
				modify(sat,'HOLIDAY');
			});
			abs.forEach(sat=>{
				modify(sat,'ABSENT');
			});
			off.forEach(sat=>{
				modify(sat,'off');
			});
		})
		function modify(day,event){
			$("tr.entry:nth-child("+day+")").replaceWith('<tr><td>'+day+'</td><td colspan=4>'+event.toUpperCase()+'</td><td></td><td></td></tr>')
		}
	</script>
</body>
</html>