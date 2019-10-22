<?php

// init();

function init(){
    global $employee_id;
    global $year;
    global $month;
    global $cutoff;

    if($cutoff == 1){
        firstCutOff($employee_id,$year,$month);
    }else if($cutoff == 2){
        secondCutOff($employee_id,$year,$month);
    }else{
        fullMonth($employee_id,$year,$month);
    }
}

function firstCutOff($employee_id,$year,$month){

    for($dtr_days=1;$dtr_days<=15;$dtr_days++) {
        GetDTRRow($employee_id,$month,$dtr_days,$year);
    }		
    
    for($extratd=16;$extratd<=31;$extratd++) {
        GetDTRBlankRow($extratd);
    }	
}

function secondCutOff($employee_id,$year,$month){

    for($extratd=1;$extratd<=15;$extratd++) {
        GetDTRBlankRow($extratd);
    }

    for($dtr_days=16;$dtr_days<=31;$dtr_days++) {
        GetDTRRow($employee_id,$month,$dtr_days,$year);
    }

}

function fullMonth($employee_id,$year,$month){

    for($dtr_days=1;$dtr_days<=31;$dtr_days++) {
        GetDTRRow($employee_id,$month,$dtr_days,$year);
    }

}

function GetDTRBlankRow($extratd){
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

function GetDTRRow($employee_id,$month,$dtr_days,$year){
    global $con;
    global $shifting_days;
    global $saturdays;
    global $sundays;
    global $offs;
    global $absents;

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
        
    }else{

        if(array_search($dtr_days,$offs) !== false){
            print '<tr><td>'.$dtr_days.'</td><td colspan="4">OFF</td><td></td><td></td></tr>';
            return;
        }

        if(array_search($dtr_days,$absents) !== false){
            print '<tr><td>'.$dtr_days.'</td><td colspan="4">ABSENT</td><td></td><td></td></tr>';
            return;
        }

        $query = "SELECT count(*) AS cnt FROM log WHERE employee_id = '".$employee_id."' AND year = ".$year." AND month = ".$month." AND day = ".$dtr_days;
        $entry_count = mysqli_fetch_object(mysqli_query($con,$query))->cnt;

        if($entry_count == 0){
            if(array_search($dtr_days,$saturdays) !== false){
                print '<tr><td>'.$dtr_days.'</td><td colspan="4">SATURDAY</td><td></td><td></td></tr>';
                return;
            }else if(array_search($dtr_days,$sundays) !== false){
                print '<tr><td>'.$dtr_days.'</td><td colspan="4">SUNDAY</td><td></td><td></td></tr>';
                return;
            }
        }

        print '
            <tr class="entry">
                <td>'.$dtr_days.'</td>';

        print  '<td>';
                print GetDTREntry($employee_id,$year,$month,$dtr_days,1,$override);
        print '</td>';

        print '<td>';
                print GetDTREntry($employee_id,$year,$month,$dtr_days,2,$override);
        print '</td>';
        print '<td>';
                print GetDTREntry($employee_id,$year,$month,$dtr_days,3,$override);
        print '</td>';
        print '<td>';
                print GetDTREntry($employee_id,$year,$month,$dtr_days,4,$override);
        if(count($override) > 0){
            $res = reset($override);
            print '</td>
                <td colspan=2 nowrap style="font-size:10px;">'.$res->reason.'</td>
            </tr>';
        }else{
            // todo : compute tardy
            print '</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            ';
        }

    }
}

function GetDTREntry($employee_id,$year,$month,$day,$type,$override){
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