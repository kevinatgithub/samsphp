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

function GetOverrideOfDay($year,$month,$day,$employee_id){
    global $con;
    $row_date = $month."/".$day."/".$year;
    $query = "SELECT * FROM override WHERE approved_by IS NOT NULL AND disabled_dt IS NULL AND employee_id = '$employee_id' AND date = '$row_date'";
    $rs_overrides = mysqli_query($con,$query) or exit(mysqli_error($con));
    $override = [];
    if(mysqli_num_rows($rs_overrides)){
        while($or_row = mysqli_fetch_object($rs_overrides)){
            $override[$or_row->type] = $or_row;
        }
    }
    return $override;
}

function GetDTRRow($employee_id,$month,$dtr_days,$year){
    global $con;
    global $shifting_days;
    global $saturdays;
    global $sundays;
    global $offs;
    global $absents;
    global $half_days;

    // Check for whole day overrides
    $override = GetOverrideOfDay($year,$month,$dtr_days,$employee_id);
    if(array_key_exists(0, $override) !== false){
        print '<tr><td>'.$dtr_days.'</td><td>08:00</td><td>12:00</td><td>12:01</td><td>05:00</td><td colspan=2 nowrap style="font-size:10px;">'.$override[0]->reason.'</td></tr>';
        return;
    }

    // Check for offs
    if(array_search($dtr_days,$offs) !== false){
        print '<tr><td>'.$dtr_days.'</td><td colspan="4">OFF</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
        return;
    }

    // Check for absents
    if(array_search($dtr_days,$absents) !== false){
        print '<tr><td>'.$dtr_days.'</td><td colspan="4">ABSENT</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
        return;
    }

    // Verify if has entry for the day
    $query = "SELECT * FROM log WHERE employee_id = '".$employee_id."' AND year = ".$year." AND month = ".$month." AND day = ".$dtr_days;
    $rs = mysqli_query($con,$query);
    $entry_count = mysqli_num_rows($rs);

    // If no entry
    if($entry_count == 0){

        // If weekend
        if(array_search($dtr_days,$saturdays) !== false){
            print '<tr><td>'.$dtr_days.'</td><td colspan="4">SATURDAY</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
            return;
        }else if(array_search($dtr_days,$sundays) !== false){
            print '<tr><td>'.$dtr_days.'</td><td colspan="4">SUNDAY</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
            return;
        }
    }

    $am_in = ''; $am_out = ''; $pm_in = ''; $pm_out = '';

    while($row = mysqli_fetch_object($rs)){
        switch($row->type){
            case 1: $am_in = $row->time; break;
            case 2: $am_out = $row->time; break;
            case 3: $pm_in = $row->time; break;
            case 4: $pm_out = $row->time; break;
        }
    }

    print '
        <tr class="entry">
            
            <td>'.
                $dtr_days.
            '</td>';

    print  '<td>';
            $am_in = GetDTREntry($employee_id,$year,$month,$dtr_days,1,$override,$am_in);
            print $am_in;
    print '</td>';

    print '<td>';
            $am_out = GetDTREntry($employee_id,$year,$month,$dtr_days,2,$override,$am_out);
            $pm_out = GetDTREntry($employee_id,$year,$month,$dtr_days,4,$override,$pm_out);
            if(array_search($dtr_days,$half_days) !== false){
                if($am_out == "&nbsp;"){
                    print $pm_out;
                }else{
                    print $am_out;
                }
            }else{
                print $am_out;
            }
    print '</td>';

    print '<td>';
            $pm_in = GetDTREntry($employee_id,$year,$month,$dtr_days,3,$override,$pm_in);
            if(array_search($dtr_days,$half_days) !== false){
                print "&nbsp;";
            }else{
                print  $pm_in;
            }
    print '</td>';

    print '<td>';
            $pm_out = GetDTREntry($employee_id,$year,$month,$dtr_days,4,$override,$pm_out);
            if(array_search($dtr_days,$half_days) !== false){
                print "&nbsp;";
            }else{
                print $pm_out;
            }
    print '</td>';

    if(count($override) > 0){
        $res = reset($override);
        print '<td colspan=2 nowrap style="font-size:10px;">'.$res->reason.'</td>';
    }else{
        print GetComputedTardy($year,$month,$dtr_days,[
            'am_in' => $am_in,
            'am_out' => $am_out,
            'pm_in' => $pm_in,
            'pm_out' => $pm_out
        ]);
    }

    print '</tr>';
}

function GetDTREntry($employee_id,$year,$month,$day,$type,$override,$time_entry){
	global $con;
	if(array_key_exists($type, $override) !== false){
		return str_pad($override[$type]->time, 5, '0', STR_PAD_LEFT);
    }
    
    if($time_entry == ''){
        return '&nbsp;';
    }else{
        return date("h:i", strtotime($time_entry));
    }
    
}

function GetComputedTardy($year,$month,$day,$entries){
    global $shifting_days;
    global $holidays;
    global $half_days;

    // todo : compute tardy
    // return '<td>&nbsp;</td><td>&nbsp;</td>';

    /*
        require parameters:
            year, month, day, time entries, 

        #4 If monday 7:00 - 8:00, Include Lunch break
        #5 If not monday 7:00 - 9:30 but weekday, Include Lunch break
        #1 #2 If holiday/weekend check if shifting
        #3 If shifting, on Weekdays 2:00 to 10:00
        #1 #2 If shifting, on Holiday/weekend 10:00 to 6:00

        Able to detect Day of Week
        Able to compute for lunch
    */

    // get what day
    $m = str_pad($month,2,'0',STR_PAD_LEFT);
    $d = str_pad($day,2,'0',STR_PAD_LEFT);
    $dayOfWeek = date('w', strtotime($year.'-'.$m.'-'.$d));

    // print($day.' = ' . $dayOfWeek . '<br>');

    // Weekends not shifting
    if(($dayOfWeek == 0 || $dayOfWeek == 6) && array_search($day,$shifting_days) === false){
        return '<td>&nbsp;</td><td>&nbsp;</td>';
    }

    // Monday apply 7:00 - 8:00 with lunch
    if($dayOfWeek == 1 && array_search($day,$shifting_days) === false){
        return GetTardy($entries,true,'7:00','8:00');
    }
    // Halfday apply 8:00 to 12:00 
    if(($dayOfWeek > 1 &&  $dayOfWeek < 6) &&  array_search($day,$half_days) !== false){
        return GetTardyHalfday($entries);
    }

    // Thuesday to Friday apply 7:00 - 9:30 with lunch
    if(($dayOfWeek > 1 &&  $dayOfWeek < 6) && array_search($day,$shifting_days) === false){
        return GetTardy($entries,true,'7:00','9:30');
    }

    // Holiday apply 10:00 to 6:00 No Lunch break
    if(array_search($day,$holidays) !== false && array_search($day,$shifting_days) !== false){
        return GetTardy($entries,false,'10:00','10:00');
    }

    // Shifitng on Weekend apply 10:00 to 6:00 No Lunch break
    if(($dayOfWeek == 0 || $dayOfWeek == 6) && array_search($day,$shifting_days) !== false){
        return GetTardy($entries,false,'10:00','10:00');
    }
    
    // Shifting Monday to Friday apply 2:00 to 10:00 No Lunch break
    if(($dayOfWeek > 0 &&  $dayOfWeek < 6) && array_search($day,$shifting_days) !== false){
        return GetTardy($entries,false,'14:00','14:00');
    }

}

function GetTardy($entries,$lunch,$earliest,$latest){

    // check data completeness
    if($lunch){
        if($entries['am_in'] == "&nbsp;" || $entries['am_out'] == "&nbsp;"  || $entries['pm_in'] == "&nbsp;"  || $entries['pm_out'] == "&nbsp;"){
            return '<td>&nbsp;</td><td>&nbsp;</td>';
        }
    }else if($latest == "14:00"){
        if($entries['pm_in'] == "&nbsp;"  || $entries['pm_out'] == "&nbsp;"){
            return '<td>&nbsp;</td><td>&nbsp;</td>';
        }
    }else if($latest == "10:00"){
        if($entries['am_in'] == "&nbsp;"  || $entries['pm_out'] == "&nbsp;"){
            return '<td>&nbsp;</td><td>&nbsp;</td>';
        }
    }

    $pm_in = add12Hours($entries['pm_in']);
    $pm_out = add12Hours($entries['pm_out']);
    
    
    $am_in = !empty($entries['am_in']) ? strtotime(date("Y-m-d ") . $entries['am_in']) : null;
    if($latest == "14:00"){
        $am_in = add12Hours($entries['pm_in']);
        $am_in = !empty($am_in) ? strtotime(date("Y-m-d ") . $am_in) : null;
    }
    $am_out = !empty($entries['am_out']) ? strtotime(date("Y-m-d ") . $entries['am_out']) : null;
    $pm_in = !empty($entries['pm_in']) ? strtotime(date("Y-m-d ") . $pm_in) : null;
    $pm_out = !empty($entries['pm_out']) ? strtotime(date("Y-m-d ") . $pm_out) : null;
    $work_hours = $lunch ? 9 : 8;
    $latest = strtotime(date("Y-m-d ") . $latest);
    $latest_out = $latest + (60*60*$work_hours);

    $am_late_seconds = ($am_in - $latest);
    $am_late = $am_late_seconds <= 0 ? 0 : $am_late_seconds;

    $pm_undertime_seconds = 0;
    $expected_out = $am_in + (60*60*$work_hours);
    $expected_out = $expected_out > $latest_out ? $latest_out : $expected_out;
    if($pm_out < $expected_out){
        $pm_undertime_seconds = ($expected_out - $pm_out) + 60;
    }
    $pm_undertime = $pm_undertime_seconds <= 0 ? 0 : $pm_undertime_seconds;

    $tardy = ($am_late + $pm_undertime) / 60;

    return '<td>'.floor($tardy / 60).'</td><td>'.($tardy % 60).'</td>';
}

function GetTardyHalfday($entries){
    $lunch = false;
    $earliest = "8:00";
    $latest = "8:00";

    // check data completeness
    if($entries['am_in'] == "&nbsp;" || $entries['am_out'] == "&nbsp;"){
        if($entries['am_in'] == "&nbsp;"){
            return '<td>&nbsp;</td><td>&nbsp;</td>';
        }else if($entries['am_out'] == "&nbsp;" && $entries['pm_out'] == "&nbsp;"){
            return '<td>&nbsp;</td><td>&nbsp;</td>';
        }
    }

    if($entries['am_out'] == "&nbsp;"){
        $entries['am_out'] = $entries['pm_out'];
    }

    $entries['am_out'] = add12Hours($entries['am_out']);
   
    $am_in = strtotime(date("Y-m-d ") . $entries['am_in']);
    $am_out = strtotime(date("Y-m-d ") . $entries['am_out']);

    $work_hours = 4;

    $latest = strtotime(date("Y-m-d ") . $latest);
    $latest_out = $latest + (60*60*$work_hours);

    $am_late_seconds = ($am_in - $latest);
    $am_late = $am_late_seconds <= 0 ? 0 : $am_late_seconds;

    $am_undertime_seconds = 0;
    
    $expected_out = $am_in + (60*60*$work_hours);
    $expected_out = $expected_out > $latest_out ? $latest_out : $expected_out;
    
    if($am_out < $expected_out){
        $am_undertime_seconds = ($expected_out - $am_out) + 60;
    }

    $am_undertime = $am_undertime_seconds <= 0 ? 0 : $am_undertime_seconds;

    $tardy = ($am_late + $am_undertime) / 60;

    return '<td>'.floor($tardy / 60).'</td><td>'.($tardy % 60).'</td>';
}

function add12Hours($time){
    $array_pm_in = explode(":",$time);
    
    if(count($array_pm_in) == 2){
        if($array_pm_in[0] < 12){
            $array_pm_in[0] += 12;
            $time = implode(":",$array_pm_in);
        }
    }
    
    return $time;
}