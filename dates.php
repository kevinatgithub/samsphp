<?php

date_default_timezone_set("Asia/Manila");
echo "The time is " . date("d-m-Y h:i:sa");


print "<br>Today's Date / Time: ". date("d-m-Y h:i:s");

$date_today = date("m-d-Y h:i:s");

$date_string = strtotime($date_today);
$month = date("m", $date_string);

print "<br>Month: ".$month;


for($i=1;$i<=31;$i++) {
	print "<br>".$i;
}


?>
