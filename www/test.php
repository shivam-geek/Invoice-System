<?php
$date = $date = date("d/m/y");

$d = date_parse_from_format("d/m/y", $date);

 $year_current = str_replace("20","",$d['year']);

if($d["month"] > 3) {
    $year_previous = $year_current;
    $year_next = $year_current+ 1;
} else {
    $year_previous = $year_current - 1;
    $year_next = $year_current;
}
echo $year;


?>