<?php

class DateHelper {
    
    //Date format is year-month-day
    public static function isDate($date) {
        list($year, $month, $day) = explode("-", $date);
        if($year && $month && $day && checkdate($month, $day, $year)){
            return true;
        } else {
            return false;
        }
    }
}