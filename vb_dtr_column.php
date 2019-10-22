
<?php

    // Generate DTR Entries
    require "vb_dtr_cutoff.php";

    top();
    init();
    bottom();
    
    top();
    init();
    bottom();


function top(){
    global $row;
    global $print_month;
    global $print_cutoff;
    global $year;
    ?>
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
                    <th colspan="2">UNDERTIME/TARDY</th>
                </tr>
            </thead>
            <tr>
                <th>&nbsp;</th>
                <th width="50">Arrival</th>
                <th width="50">Departure</th>
                <th width="50">Arrival</th>
                <th width="50">Departure</th>
                <th width="50">Hour</th>
                <th width="50">Minute</th>
            </tr>
            <tbody>
    <?php
}

function bottom(){
    global $signatory;
    global $position;
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
                <?=$signatory?><br/>
                <i><?=$position?></i>
                </th>
            </tr>
        </table>
    </div>
    <?php
}

?>