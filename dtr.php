<?php
	include "config/config.php";

	$employee_no = $_POST['employee_no'];
	$month = $_POST['month'];
	$cutoff = $_POST['cutoff'];
	$year = $_POST['year'];

	$month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

	$employee = mysql_query("SELECT * FROM employee WHERE employee_no = '$employee_no'");
	$row = mysql_fetch_array($employee);
		$employee_id = $row['id'];
		$print_month = strftime("%B",mktime(0,0,0,$month));

		if($cutoff == 1) { $print_cutoff =  '1-15'; }
		else if($cutoff == 2) { $print_cutoff = '16-'.$month_days; }
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
						<td width="30%" class="blank"></td>
					</tr>
					<tr>
						<td class="text-right">Saturdays</td>
						<td class="blank"></td>
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
						<th></th>
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
						for($dtr_days=1;$dtr_days<=15;$dtr_days++) {

							print '
								<tr>
									<td>'.$dtr_days.'</td>
									<td>';
										$am1 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 1");

										$row_am1 = mysql_fetch_assoc($am1);

											if($row_am1['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_am1['time']));
											}	

									
									print '</td>
									<td>';
										$am2 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 2");

										$row_am2 = mysql_fetch_assoc($am2);

											if($row_am2['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_am2['time']));
											}	

									print '</td>
									<td>';
										$pm1 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 3");

										$row_pm1 = mysql_fetch_assoc($pm1);

											if($row_pm1['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_pm1['time']));
											}	

									print '
									</td>
									<td>';
										$pm2 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 4");

										$row_pm2 = mysql_fetch_assoc($pm2);

											if($row_pm2['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_pm2['time']));
											}	
									print '</td>
									<td></td>
									<td></td>
								</tr>
							';
						}		

						for($extratd=16;$extratd<=31;$extratd++) {
							print '
								<tr>
									<td>'.$extratd.'</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							';	
						}										
					}

					elseif($cutoff == 2) {
						for($extratd=1;$extratd<=15;$extratd++) {
							print '
								<tr>
									<td>'.$extratd.'</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							';	
						}	
						for($dtr_days=16;$dtr_days<=31;$dtr_days++) {
							print '
								<tr>
									<td>'.$dtr_days.'</td>
									<td>';
										$am1 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 1");

										$row_am1 = mysql_fetch_assoc($am1);

											if($row_am1['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_am1['time']));
											}	

									
									print '</td>
									<td>';
										$am2 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 2");

										$row_am2 = mysql_fetch_assoc($am2);

											if($row_am2['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_am2['time']));
											}	

									print '</td>
									<td>';
										$pm1 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 3");

										$row_pm1 = mysql_fetch_assoc($pm1);

											if($row_pm1['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_pm1['time']));
											}	

									print '
									</td>
									<td>';
										$pm2 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 4");

										$row_pm2 = mysql_fetch_assoc($pm2);

											if($row_pm2['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_pm2['time']));
											}	
									print '</td>
									<td></td>
									<td></td>
								</tr>
							';
						}
					}

					elseif($cutoff == 3) {
						for($dtr_days=1;$dtr_days<=31;$dtr_days++) {
							print '
								<tr>
									<td>'.$dtr_days.'</td>
									<td>';
										$am1 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 1");

										$row_am1 = mysql_fetch_assoc($am1);

											if($row_am1['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_am1['time']));
											}	

									
									print '</td>
									<td>';
										$am2 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 2");

										$row_am2 = mysql_fetch_assoc($am2);

											if($row_am2['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_am2['time']));
											}	

									print '</td>
									<td>';
										$pm1 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 3");

										$row_pm1 = mysql_fetch_assoc($pm1);

											if($row_pm1['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_pm1['time']));
											}	

									print '
									</td>
									<td>';
										$pm2 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 4");

										$row_pm2 = mysql_fetch_assoc($pm2);

											if($row_pm2['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_pm2['time']));
											}	
									print '</td>
									<td></td>
									<td></td>
								</tr>
							';
						}
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
						<td width="30%" class="blank"></td>
					</tr>
					<tr>
						<td class="text-right">Saturdays</td>
						<td class="blank"></td>
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
						<th></th>
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
						for($dtr_days=1;$dtr_days<=15;$dtr_days++) {

							print '
								<tr>
									<td>'.$dtr_days.'</td>
									<td>';
										$am1 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 1");

										$row_am1 = mysql_fetch_assoc($am1);

											if($row_am1['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_am1['time']));
											}	

									
									print '</td>
									<td>';
										$am2 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 2");

										$row_am2 = mysql_fetch_assoc($am2);

											if($row_am2['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_am2['time']));
											}	

									print '</td>
									<td>';
										$pm1 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 3");

										$row_pm1 = mysql_fetch_assoc($pm1);

											if($row_pm1['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_pm1['time']));
											}	

									print '
									</td>
									<td>';
										$pm2 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 4");

										$row_pm2 = mysql_fetch_assoc($pm2);

											if($row_pm2['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_pm2['time']));
											}	
									print '</td>
									<td></td>
									<td></td>
								</tr>
							';
						}		

						for($extratd=16;$extratd<=31;$extratd++) {
							print '
								<tr>
									<td>'.$extratd.'</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							';	
						}										
					}

					elseif($cutoff == 2) {
						for($extratd=1;$extratd<=15;$extratd++) {
							print '
								<tr>
									<td>'.$extratd.'</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							';	
						}	
						for($dtr_days=16;$dtr_days<=31;$dtr_days++) {
							print '
								<tr>
									<td>'.$dtr_days.'</td>
									<td>';
										$am1 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 1");

										$row_am1 = mysql_fetch_assoc($am1);

											if($row_am1['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_am1['time']));
											}	

									
									print '</td>
									<td>';
										$am2 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 2");

										$row_am2 = mysql_fetch_assoc($am2);

											if($row_am2['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_am2['time']));
											}	

									print '</td>
									<td>';
										$pm1 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 3");

										$row_pm1 = mysql_fetch_assoc($pm1);

											if($row_pm1['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_pm1['time']));
											}	

									print '
									</td>
									<td>';
										$pm2 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 4");

										$row_pm2 = mysql_fetch_assoc($pm2);

											if($row_pm2['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_pm2['time']));
											}	
									print '</td>
									<td></td>
									<td></td>
								</tr>
							';
						}
					}

					elseif($cutoff == 3) {
						for($dtr_days=1;$dtr_days<=31;$dtr_days++) {
							print '
								<tr>
									<td>'.$dtr_days.'</td>
									<td>';
										$am1 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 1");

										$row_am1 = mysql_fetch_assoc($am1);

											if($row_am1['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_am1['time']));
											}	

									
									print '</td>
									<td>';
										$am2 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 2");

										$row_am2 = mysql_fetch_assoc($am2);

											if($row_am2['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_am2['time']));
											}	

									print '</td>
									<td>';
										$pm1 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 3");

										$row_pm1 = mysql_fetch_assoc($pm1);

											if($row_pm1['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_pm1['time']));
											}	

									print '
									</td>
									<td>';
										$pm2 = mysql_query("SELECT time FROM log 
										WHERE employee_id = $employee_id
											AND year = $year
											AND month = $month
											AND day = $dtr_days
											AND type = 4");

										$row_pm2 = mysql_fetch_assoc($pm2);

											if($row_pm2['time'] == '') { print ''; }
											else { print 
												date("h:i", strtotime($row_pm2['time']));
											}	
									print '</td>
									<td></td>
									<td></td>
								</tr>
							';
						}
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