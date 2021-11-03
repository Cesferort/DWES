<?php
define("DATE_FORMATS", 
[
    "AM_PM" => "A",
    "MILLISECONDS" => "v",
    "SECONDS" => "s",
    "MINUTES" => "i",
    "HOUR_12" => "h",
    "HOUR_24" => "H",
    "DAY" => "d",
    "DAY_TEXT" => "l",
    "MONTH" => "m",
    "MONTH_TEXT" => "F",
    "YEAR" => "Y"
]);

function formatDate_vigentes($datestr)
{
    $month=getFormatedDate($datestr, DATE_FORMATS["MONTH"]);
    $day=getFormatedDate($datestr, DATE_FORMATS["DAY"]);
    $year=getFormatedDate($datestr, DATE_FORMATS["YEAR"]);
    
    $hour=getFormatedDate($datestr, DATE_FORMATS["HOUR_24"]);
    $minute=getFormatedDate($datestr, DATE_FORMATS["MINUTES"]);
    $second=getFormatedDate($datestr, DATE_FORMATS["SECONDS"]);

    return $month."/".$day."/".$year." ".$hour.":".$minute.":".$second; 
}

function formatDate_vencidas($datestr)
{
    $day=getFormatedDate($datestr, DATE_FORMATS["DAY"]);
    $month=getFormatedDate($datestr, DATE_FORMATS["MONTH_TEXT"]);
    $year=getFormatedDate($datestr, DATE_FORMATS["YEAR"]);
    $hour=getFormatedDate($datestr, DATE_FORMATS["HOUR_24"]);
    $minute=getFormatedDate($datestr, DATE_FORMATS["MINUTES"]);
    
    return $day."-".$month."-".$year." ".$hour.":".$minute; 
}
function getFormatedDate($datestr, $format) 
{
    $date=new Datetime($datestr);
    return $date -> format($format);
}
?>