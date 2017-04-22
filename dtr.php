<?php
	include "config/config.php";

	$employee_no = $_REQUEST['employee_no'];
	$month = $_REQUEST['month'] * 1;
	$cutoff = $_REQUEST['cutoff'];
	$year = $_REQUEST['year'];

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
?>
<!DOCTYPE html>
<html>
<head>
	<title>DTR</title>
	<link rel="stylesheet" type="text/css" href="css/export-dtr.css">
</head>
<body>
	<div class="container">
			<div class="left">
				<center>
				<b><p>DAILY TIME RECORD</p></b>
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
				</table>
				<br>
				<table width="100%" class="subs">
					<tr>
						<td class="text-left"><small>I CERTIFY on my honor that the above is a true and correct report of the hours of work performed, record of which was made daily at the time of arrival at and departure from office.</small></td>
					</tr>
					<tr>
						<td class="blank"><br><br></td>
					</tr>
					<tr>
						<td><small>SIGNATURE</small></td>
					</tr>
					<tr>
						<td class="blank"><br><br></td>
					</tr>
					<tr>
						<td><small>IMMEDIATE SUPERVISOR</small></td>
					</tr>
					<tr>
						<td><small>
						Verified as to the prescribed office hours.
						</small>
						</td>
					</tr>
					<tr>
						<td class="blank"><br><br></td>
					</tr>
					<tr>
						<td><small>JULIUS A. LECCIONES, MD, MHSA, MPM, MScHSM, CESO III<br>
						Executive Director</small></td>
					</tr>
				</table>
			</div>

			<div class="left">
				<center>
				<b><p>DAILY TIME RECORD</p></b>
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
				</table>
				<br>
				<table width="100%" class="subs">
					<tr>
						<td class="text-left"><small>I CERTIFY on my honor that the above is a true and correct report of the hours of work performed, record of which was made daily at the time of arrival at and departure from office.</small></td>
					</tr>
					<tr>
						<td class="blank"><br><br></td>
					</tr>
					<tr>
						<td><small>SIGNATURE</small></td>
					</tr>
					<tr>
						<td class="blank"><br><br></td>
					</tr>
					<tr>
						<td><small>IMMEDIATE SUPERVISOR</small></td>
					</tr>
					<tr>
						<td><small>
						Verified as to the prescribed office hours.
						</small>
						</td>
					</tr>
					<tr>
						<td class="blank"><br><br></td>
					</tr>
					<tr>
						<td><small>JULIUS A. LECCIONES, MD, MHSA, MPM, MScHSM, CESO III<br>
						Executive Director</small></td>
					</tr>
				</table>
			</div>
	</div>
</body>
</html>