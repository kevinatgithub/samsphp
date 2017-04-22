<?php
for($extratd=1;$extratd<=15;$extratd++) {
	print '
		<tr>
			<td>'.$extratd.'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	';	
}	
for($dtr_days=16;$dtr_days<=31;$dtr_days++) {

	$row_date = $month."/".$dtr_days."/".$year;
	$query = "SELECT * FROM override WHERE approved_by IS NOT NULL AND disabled_dt IS NULL AND employee_id = '$employee_id' AND date = '$row_date'";
	$rs_overrides = mysqli_query($con,$query) or exit(mysqli_error($con));
	$override = [];
	if(mysqli_num_rows($rs_overrides)){
		while($or_row = mysqli_fetch_object($rs_overrides)){
			$override[$or_row->type] = $or_row;
		}
	}

	if(array_key_exists(0, $override) !== false){
		print '<tr><td>'.$dtr_days.'</td><td>08:00</td><td>12:00</td><td>12:01</td><td>05:00</td><td colspan=2 nowrap style="font-size:10px;">'.$override[0]->reason.'</td></tr>';
		continue;
	}
	
	print '
		<tr>
			<td>'.$dtr_days.'</td>';

	print  '<td>';
			print GetDTRTimeEntry($employee_id,$year,$month,$dtr_days,1,$override);
	print '</td>';

	print '<td>';
			print GetDTRTimeEntry($employee_id,$year,$month,$dtr_days,2,$override);
	print '</td>';
	print '<td>';
			print GetDTRTimeEntry($employee_id,$year,$month,$dtr_days,3,$override);
	print '</td>';
	print '<td>';
			print GetDTRTimeEntry($employee_id,$year,$month,$dtr_days,4,$override);
	print '</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	';
}