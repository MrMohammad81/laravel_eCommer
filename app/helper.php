<?php

use Hekmatinasser\Verta\Facades\Verta;

function generatiFileNameWithDate($name)
 {
     $year =   Verta::now()->year;
     $month =  Verta::now()->month;
     $day =  Verta::now()->day;
     $hour =  Verta::now()->hour;
     $minute =  Verta::now()->minute;
     $second =  Verta::now()->second;
     $microsecond =  Verta::now()->micro;

     return $year.'_'.$month.'_'.$day.' '.$hour.'-'.$minute.'-'.$second.'-'.$microsecond.' '.$name;
 }


 function convertShamsiDateToGregorian($date)
 {
     if ($date == null)
     {
         return null;
     }
     $pattern = "/[-\s]/";

     $shamsiDateSplit = preg_split($pattern , $date);

     $arrayGregorian = Verta::jalaliToGregorian($shamsiDateSplit[0] , $shamsiDateSplit[1] , $shamsiDateSplit[2]);

     return implode('-' , $arrayGregorian) . ' ' . $shamsiDateSplit[3];
 }
