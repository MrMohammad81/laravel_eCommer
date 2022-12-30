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
